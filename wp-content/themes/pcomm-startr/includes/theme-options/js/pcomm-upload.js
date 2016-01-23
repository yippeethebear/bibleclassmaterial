jQuery(document).ready(function($) {
	$('#upload_logo').click(function() {
		tb_show('Upload a logo', 'media-upload.php?referer=theme_options&amp;type=image&amp;TB_iframe=true', false);
		return false;
	});
});
	window.send_to_editor = function(html) {
		var image_url = jQuery('img',html).attr('src');
		jQuery('#logo_url').val(image_url);
		tb_remove();
		jQuery('#upload_logo_preview img').attr('src',image_url);
		jQuery('#submit').trigger('click');
	};