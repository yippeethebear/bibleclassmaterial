<?php
/**
 * PComm Theme Options
 *
 * @package PComm
 * @since PComm 1.0
 */

/**
 * Register the form setting for our pcomm_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, pcomm_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are properly
 * formatted, and safe.
 *
 * @since PComm 1.0
 */
function pcomm_theme_options_init() {
	register_setting(
		'pcomm_options',       // Options group, see settings_fields() call in pcomm_theme_options_render_page()
		'pcomm_theme_options', // Database option, see pcomm_get_theme_options()
		'pcomm_theme_options_validate' // The sanitization callback, see pcomm_theme_options_validate()
	);

	// Register our settings field group
	add_settings_section(
		'general', // Unique identifier for the settings section
		'General settings', // Section title (we don't want one)
		'__return_false', // Section callback (we don't want anything)
		'theme_options' // Menu slug, used to uniquely identify the page; see pcomm_theme_options_add_page()
	);

	add_settings_field( 'pcomm_theme_namespace', 'Theme namespace', 'pcomm_settings_field_input', 'theme_options', 'general', array('id' => 'pcomm_theme_namespace', 'desc' => 'Theme namespace to be added as body class.') );
	add_settings_field( 'pcomm_company_name', 'Company name', 'pcomm_settings_field_input', 'theme_options', 'general', array('id' => 'pcomm_company_name', 'desc' => 'Official company name for copyright and elsewhere.') );
	add_settings_field( 'pcomm_company_logo', 'Company\'s logo', 'pcomm_settings_company_logo', 'theme_options', 'general', array('id' => 'pcomm_company_logo') );

		// Add Current Image Preview
	add_settings_field('pcomm_setting_logo_preview',  __( 'Logo Preview', 'pcomm' ), 'pcomm_setting_logo_preview', 'theme_options', 'general');


	add_settings_section( 'analytics', 
		'Google Analytics settings', 
		'__return_false', 
		'theme_options' 
	);

	add_settings_field( 'pcomm_analytics_tracking_id', 'Google Analytics Tracking ID (UA-XXXXXX)', 'pcomm_settings_field_input', 'theme_options', 'analytics', array('id' => 'pcomm_analytics_tracking_id') );

		// add_settings_field( 'sample_select_options', __( 'Sample Select Options', 'pcomm' ), 'pcomm_settings_field_sample_select_options', 'theme_options', 'general' );
	// add_settings_field( 'sample_radio_buttons', __( 'Sample Radio Buttons', 'pcomm' ), 'pcomm_settings_field_sample_radio_buttons', 'theme_options', 'general' );
	// add_settings_field( 'sample_textarea', __( 'Sample Textarea', 'pcomm' ), 'pcomm_settings_field_sample_textarea', 'theme_options', 'general' );
}
add_action( 'admin_init', 'pcomm_theme_options_init' );

/**
 * Change the capability required to save the 'pcomm_options' options group.
 *
 * @see pcomm_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see pcomm_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function pcomm_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_pcomm_options', 'pcomm_option_page_capability' );

/**
 * Add our theme options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since PComm 1.0
 */
function pcomm_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Options', 'pcomm' ),   // Name of page
		__( 'Theme Options', 'pcomm' ),   // Label in menu
		'edit_theme_options',                    // Capability required
		'theme_options',                         // Menu slug, used to uniquely identify the page
		'pcomm_theme_options_render_page' // Function that renders the options page
	);
}
add_action( 'admin_menu', 'pcomm_theme_options_add_page' );


/**
 * Returns the options array for PComm.
 *
 * @since PComm 1.0
 */
function pcomm_get_theme_options() {
	$saved = (array) get_option( 'pcomm_theme_options' );
	$defaults = array(
		'pcomm_analytics_tracking_id'     => '',
		'pcomm_theme_namespace' => 'bcm',
		'pcomm_company_logo'     => '',
		'pcomm_analytics_on' => 'on',
		'pcomm_company_name' => '',
		'pcomm_company_logo_remove' => ''
	);

	$defaults = apply_filters( 'pcomm_default_theme_options', $defaults );

	$options = wp_parse_args( $saved, $defaults );
	$options = array_intersect_key( $options, $defaults );

	return $options;
}


/**
 * Renders the text input setting field.
 */
function pcomm_settings_field_input($args) {
	$options = pcomm_get_theme_options();
	if (isset($args['type'])) {
		$type = $args['type'];
	}
	else {
		$type = 'text';
	}
	?>
	<input type="<?php echo $type; ?>" name="pcomm_theme_options[<?php echo $args['id']; ?>]" id="<?php echo $args['id']; ?>" value="<?php echo esc_attr( $options[$args['id']] ); ?>" />
	<?php if (isset($args['desc'])) { ?>
		<label class="description" for="<?php echo $args['id']; ?>"><?php _e( $args['desc'], 'pcomm' ); ?></label>
	<?php }
}



/**
 * Renders the company logo setting field.
 */
function pcomm_settings_company_logo() {
	$options = pcomm_get_theme_options();
	?>
	<input type="hidden" id="logo_url" name="pcomm_theme_options[pcomm_company_logo]" value="<?php echo esc_url( $options['pcomm_company_logo'] ); ?>" />  
	<?php if ( '' != $options['pcomm_company_logo'] ): ?>
		<input id="upload_logo" type="button" class="button" value="<?php echo 'Upload new logo'; ?>" />
		<input id="remove_logo" name="pcomm_theme_options[pcomm_company_logo_remove]" type="submit" class="button" value="<?php _e( 'Don\'t use this logo', 'logo', 'pcomm' ); ?>" />  
	<?php else : ?>
		<input id="upload_logo" type="button" class="button" value="<?php echo 'Upload logo'; ?>" />
	<?php endif; ?>
<?php 
}

/**
 * Renders the sample checkbox setting field.
 */
function pcomm_settings_field_checkbox($args) {
	$options = pcomm_get_theme_options();
	?>
	<label for"<?php echo $args['id']; ?>">
		<input type="checkbox" name="pcomm_theme_options[<?php echo $args['id']; ?>]" id="<?php echo $args['id']; ?>" <?php checked( 'on', $options[$args['id']] ); ?> />
		
	</label>
	<?php if (isset($args['desc'])) { ?>
		<label class="description" for="<?php echo $args['id']; ?>"><?php _e( $args['desc'], 'pcomm' ); ?></label>
	<?php }
}
/**
 * Renders the Theme Options administration screen.
 *
 * @since PComm 1.0
 */
function pcomm_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Options', 'pcomm' ), get_current_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'pcomm_options' );
				do_settings_sections( 'theme_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see pcomm_theme_options_init()
 * @todo set up Reset Options action
 *
 * @param array $input Unknown values.
 * @return array Sanitized theme options ready to be stored in the database.
 *
 * @since PComm 1.0
 */
function pcomm_theme_options_validate( $input ) {
	$output = array();
	$submit = ! empty($input['submit']) ? true : false;
	$reset = ! empty($input['pcomm_company_logo_remove']) ? true : false;
	$delete_logo = ! empty($input['pcomm_company_logo_delete']) ? true : false;
	$options = get_option('pcomm_theme_options
		'); 
	
	if ( isset( $input['pcomm_theme_namespace'] ) )
		$output['pcomm_theme_namespace'] = wp_filter_nohtml_kses( $input['pcomm_theme_namespace'] );

	if ( isset( $input['pcomm_company_name'] ) )
		$output['pcomm_company_name'] = wp_filter_nohtml_kses( $input['pcomm_company_name'] );

	// The analytics on checkbox should boolean true or false
	if ( isset( $input['pcomm_analytics_on'] ) )
		$output['pcomm_analytics_on'] = 'on';

	if ( isset( $input['pcomm_company_logo'] ) )
		$output['pcomm_company_logo'] = wp_filter_nohtml_kses( $input['pcomm_company_logo'] );

	if ( $submit ) {  
		if ( $options['pcomm_company_logo'] != $input['pcomm_company_logo'] && $options['pcomm_company_logo'] != '' ) {
			delete_image( $options['pcomm_company_logo'] );  
		}
		$output['pcomm_company_logo'] = wp_filter_nohtml_kses( $input['pcomm_company_logo'] );  
	}
	elseif ( $reset ) {  
		$output['pcomm_company_logo'] = '';  
	}  
	elseif ( $delete_logo ) {  
		delete_image( $options['pcomm_company_logo'] );  
		$output['pcomm_company_logo'] = '';  
	}

	// The text input must be safe text with no HTML tags
	if ( isset( $input['pcomm_analytics_tracking_id'] ) && ! empty( $input['pcomm_analytics_tracking_id'] ) )
		$output['pcomm_analytics_tracking_id'] = wp_filter_nohtml_kses( $input['pcomm_analytics_tracking_id'] );

	return apply_filters( 'pcomm_theme_options_validate', $output, $input );
}

function delete_image( $image_url ) {
	global $wpdb;
	// We need to get the image's meta ID.
	$query = "SELECT ID FROM wp_posts where guid = '" . esc_url($image_url) . "' AND post_type = 'attachment'";
	$results = $wpdb->get_results($query);
	// And delete it
	foreach ( $results as $row ) {
		wp_delete_attachment( $row->ID );
	}
}

function options_enqueue_scripts() {  
	wp_register_script( 'pcomm-upload', get_template_directory_uri() .'/includes/theme-options/js/pcomm-upload.js', array('jquery','media-upload','thickbox') );  
	if ( 'appearance_page_theme_options' == get_current_screen() -> id ) {  
		wp_enqueue_script('jquery');  
		wp_enqueue_script('thickbox');  
		wp_enqueue_style('thickbox');  
		wp_enqueue_script('media-upload');  
		wp_enqueue_script('pcomm-upload');  
	}  
}  
add_action('admin_enqueue_scripts', 'options_enqueue_scripts'); 

function pcomm_options_setup() {
	global $pagenow;
	if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
		// Now we'll replace the 'Insert into Post Button' inside Thickbox
		add_filter( 'gettext', 'replace_thickbox_text'  , 1, 3 );
	}
}
add_action( 'admin_init', 'pcomm_options_setup' );
function replace_thickbox_text($translated_text, $text, $domain) {
	if ('Insert into Post' == $text) {
		$referer = strpos( wp_get_referer(), 'theme_options' );
		if ( $referer != '' ) {
			return __('Add company logo', 'pcomm' );
		}
	}
	return $translated_text;
}
function pcomm_setting_logo_preview() {
	$options = pcomm_get_theme_options(); ?>
	<div id="upload_logo_preview" style="min-height: 100px;">
		<img style="max-width:100%;" src="<?php echo esc_url( $options['pcomm_company_logo'] ); ?>" />
	</div>
	<?php
}



/**
 * Renders the sample select options setting field.
 */
function pcomm_settings_field_sample_select_options() {
	$options = pcomm_get_theme_options();
	?>
	<select name="pcomm_theme_options[sample_select_options]" id="sample-select-options">
		<?php
			$selected = $options['sample_select_options'];
			$p = '';
			$r = '';

			foreach ( pcomm_sample_select_options() as $option ) {
				$label = $option['label'];
				if ( $selected == $option['value'] ) // Make default first in list
					$p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";
				else
					$r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $option['value'] ) . "'>$label</option>";
			}
			echo $p . $r;
		?>
	</select>
	<label class="description" for="sample_theme_options[selectinput]"><?php _e( 'Sample select input', 'pcomm' ); ?></label>
	<?php
}

/**
 * Renders the radio options setting field.
 *
 * @since PComm 1.0
 */
function pcomm_settings_field_sample_radio_buttons() {
	$options = pcomm_get_theme_options();

	foreach ( pcomm_sample_radio_buttons() as $button ) {
	?>
	<div class="layout">
		<label class="description">
			<input type="radio" name="pcomm_theme_options[sample_radio_buttons]" value="<?php echo esc_attr( $button['value'] ); ?>" <?php checked( $options['sample_radio_buttons'], $button['value'] ); ?> />
			<?php echo $button['label']; ?>
		</label>
	</div>
	<?php
	}
}

/**
 * Renders the sample textarea setting field.
 */
function pcomm_settings_field_sample_textarea() {
	$options = pcomm_get_theme_options();
	?>
	<textarea class="large-text" type="text" name="pcomm_theme_options[sample_textarea]" id="sample-textarea" cols="50" rows="10" /><?php echo esc_textarea( $options['sample_textarea'] ); ?></textarea>
	<label class="description" for="sample-textarea"><?php _e( 'Sample textarea', 'pcomm' ); ?></label>
	<?php
}


/**
 * Returns an array of sample select options registered for PComm.
 *
 * @since PComm 1.0
 */
function pcomm_sample_select_options() {
	$sample_select_options = array(
		'0' => array(
			'value' =>	'0',
			'label' => __( 'Zero', 'pcomm' )
		),
		'1' => array(
			'value' =>	'1',
			'label' => __( 'One', 'pcomm' )
		),
		'2' => array(
			'value' => '2',
			'label' => __( 'Two', 'pcomm' )
		),
		'3' => array(
			'value' => '3',
			'label' => __( 'Three', 'pcomm' )
		),
		'4' => array(
			'value' => '4',
			'label' => __( 'Four', 'pcomm' )
		),
		'5' => array(
			'value' => '3',
			'label' => __( 'Five', 'pcomm' )
		)
	);

	return apply_filters( 'pcomm_sample_select_options', $sample_select_options );
}

/**
 * Returns an array of sample radio options registered for PComm.
 *
 * @since PComm 1.0
 */
function pcomm_sample_radio_buttons() {
	$sample_radio_buttons = array(
		'yes' => array(
			'value' => 'yes',
			'label' => __( 'Yes', 'pcomm' )
		),
		'no' => array(
			'value' => 'no',
			'label' => __( 'No', 'pcomm' )
		),
		'maybe' => array(
			'value' => 'maybe',
			'label' => __( 'Maybe', 'pcomm' )
		)
	);

	return apply_filters( 'pcomm_sample_radio_buttons', $sample_radio_buttons );
}