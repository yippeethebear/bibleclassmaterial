 /* theme specific scripts in here */

/* jason added this to prevent console.log, etc. calls from breaking browsers where it doesn't exist. */
window.log=function(){log.history=log.history||[];log.history.push(arguments);if(this.console){console.log(Array.prototype.slice.call(arguments));}};

/* pcomm object to use as base */
var pcomm = (function($, w, undefined) {

	// adds placeholder to inputs on browsers that don't support it natively
	// <input placeholder="Example placeholder text" .... />
	function placeholder() {
		$('input').placeholder();
	}

	// see parent theme for removed functions
	// zebraTables()
	// mobileNav()
	// loadMorePosts() // should probably make that a plugin to be used as needed

	function selectedRadio() {
		$('.gform_wrapper ul.gfield_radio li input').click(function() {
		  if ($(this).is(':checked')) {
		     $(this).parents('li').addClass('selected');
		     $(this).parents('li').siblings().removeClass('selected');
		  }
		});
	}

	function addPeriodToValidationMessage() {
		var $msg = $('#field_1_4').find('.validation_message'),
			text = $msg.text();
		if ( text.slice(-1) !== '.') {
			$msg.text(text + '.');
		}
			
	}

	function stickyScroll() {
		// grab the initial top offset of the navigation 
		var sticky_navigation_offset_top = $('#sticky_navigation').offset().top;
		
		// our function that decides weather the navigation bar should have "fixed" css position or not.
		var sticky_navigation = function(){
			var scroll_top = $(window).scrollTop(); // our current vertical position from the top
			
			// if we've scrolled more than the navigation, change its position to fixed to stick to top, otherwise change it back to relative
			if (scroll_top > sticky_navigation_offset_top) { 
				$('.nav-wrap').addClass('sticky');
			} 
			if (scroll_top < sticky_navigation_offset_top) {
				$('.nav-wrap').removeClass('sticky'); 
			}   
		};
		
		// run our function on load
		sticky_navigation();
		
		// and run it again every time you scroll
		$(window).scroll(function() {
			 sticky_navigation();
		});
		
		// NOT required:
		// for this demo disable all links that point to "#"
		$('a[href="#"]').click(function(event){ 
			event.preventDefault(); 
		});
	}

	return {
		// return init function for anything that doesn't need to be called inlne
		init : function() {
			selectedRadio();
			addPeriodToValidationMessage();
			stickyScroll();
		},
		// return functions separately if they need to be called from the page
		// with parameters or for other reasons
		// like this:
		placeholder: placeholder
	};
	
} ( jQuery, window ) );

// initialize the pcvx object
pcomm.init();