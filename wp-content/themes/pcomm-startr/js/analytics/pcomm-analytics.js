// function to send an event to Google Analytics
var pcommAnalytics = (function($, w, undefined) {

  // track an event
  // accepts object with category, action, label, value and noninteraction
  // all of which are sent to GA with each event
  function trackAnalyticsEvent(event) {
    if (typeof(ga) !== "undefined") {
      // set defaults
      var category = event.category || 'Site';
      var action = event.action || 'General action';
      var label = event.label || '';
      var value = event.value || 0;
      var noninteraction = event.noninteraction || true;

      // send the event
      ga('send', 'event', {
        'eventCategory': category,   // Required
        'eventAction': action,      // Required
        'eventLabel': label,
        'eventValue': value,
        'nonInteraction' : noninteraction
      });
    }
  }

  // captures all click events, and sends events as needed for:
  // file downloads, external links and mailto links
  function trackLinkClicks() {
    $(document).on('click', 'a', function(e) {
      
      // url clicked
      var url = $(this).attr("href"), 
        // target of url
        target = $(this).attr("target"),
        // check if same or new window
        newtab = false,
        // file types tracked
        fileTypes = new RegExp(/\.(docx*|xlsx*|pptx*|zip|pdf)$/i),
        // GA action sent
        action;
      
      // considered matching against this regex to be sure this was a url or mailto link
      // (((([A-Za-z]{3,9}:)?(?:\/\/)?)(?:[\-;:&=\+\$,\w]+@)?[A-Za-z0-9\.\-]+|(?:www\.|[\-;:&=\+\$,\w]+@)[A-Za-z0-9\.\-]+)((?:\/[\+~%\/\.\w\-]*)?\??(?:[\-\+=&;%@\.\w]*)#?(?:[\.\!\/\\\w]*))?)
      // via http://blog.mattheworiordan.com/post/13174566389/url-regular-expression-for-links-with-or-without-the
      // but that seemed like overkill
      // basically we need to determine if this is a link purely used for js purposes or not so we can ignore it if so
      if (url === undefined || url === '#' || url === '') {
        return true;
      }
      
      // first, see if click was on a file matching on of the file types we're tracking
      if (fileTypes.test(url)) {
        action = 'Download';

      }
      // check if this is a mailto link
      else if (/mailto/.test(url)) {
        action = 'Email';
      } 
      else {
        // If the domains name of the link and the current url are different
        // it assumes it is an external link
        // Be careful with this if we're using subdomains
        if (e.currentTarget.hostname != window.location.hostname) {
          action = 'External Link';
        }
        else {
          // otherwise, it's just an internal link and we want to ignore it
          return true;
        }
      }

      pcommAnalytics.trackAnalyticsEvent({
        category: 'Links',
        action: action,
        label: url,
        value: 0
      });

      // Check if the ctrl or command key is held down (or if we're forcing a new tab/window)
      // which could indicate the link is being opened in a new tab
      if (e.metaKey || e.ctrlKey || target == "_blank") {
        newtab = true;
      }

      // If it is not a new tab, we need to delay the loading
      // of the new link for 100ms in order to give the
      // Google track event time to fully fire
      if (!newtab) {
        e.preventDefault();
        setTimeout('document.location = "' + url + '"', 100);
      }

    });
  }

  // tracks scroll depth on each page
  function trackScrollDepth() {
    // using plugin at js/analytics/jquery.scrolldepth.js
    // to track percentage scroll depth
    $.scrollDepth();
  }

  return {
    // function to initialize analytics tracking
    init: function() {
      trackLinkClicks();
      trackScrollDepth();
    },
    // expose pcommAnalytics.trackAnalyticsEvent for use as needed
    trackAnalyticsEvent: trackAnalyticsEvent
  };


} ( jQuery, window ) );

// start things off
pcommAnalytics.init();