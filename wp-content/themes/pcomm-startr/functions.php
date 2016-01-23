<?php

/*******************************************************************************
 ** INITIAL THEME SET UP **
 *******************************************************************************/
/* 
	- Adds Thumbnail support
	- Registers Primary and Footer nav menus
	- Adds Theme Options page
	- Adds Custom Template Tags
*/
function pcomm_theme_setup() {

	/* Enable support for Post Thumbnails */
	add_theme_support( 'post-thumbnails' );

	/* This theme uses wp_nav_menu() in one location. */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'wpcomm' ),
		// add footer menu for vxbenefits
		'footer' => __( 'Footer Links', 'wpcomm' )
	));

	// set up theme options
	require( get_template_directory() . '/includes/theme-options/theme-options.php' );

	// set up custom template tags
	// allows us, for example, to use a metabox on each post for things like tout headline
	// we'll use this new tag ( pcomm_tout_headine() ) instead of the_title() to pull a tout head if it exists
	require( get_template_directory() . '/includes/template-tags.php' );

	// custom class to allow adding meta fields to categories / taxonomies
	// https://github.com/bainternet/Tax-Meta-Class
	require( get_template_directory() . '/includes/category-meta.php' );

	// add post metabox
	require( get_template_directory() . '/includes/post-meta.php' );
}

add_action( 'after_setup_theme', 'pcomm_theme_setup' );


/*******************************************************************************
 ** REGISTER AND ENQUEUE SCRIPTS AND STYLES **
 *******************************************************************************/
function pcomm_styles() {
	
	wp_enqueue_style( 'style', 
		get_stylesheet_directory_uri() . '/style.css', 
		array(), 
	'' );

}

add_action( 'wp_enqueue_scripts', 'pcomm_styles', 10);

/* 
	Enqueues new scripts 
*/
function pcomm_scripts() {

	wp_enqueue_script( 'modernizr', 
		get_template_directory_uri() . '/js/libs/modernizr.custom.js', 
		array('jquery'), 
	'' );
	
	wp_enqueue_script( 'script', 
		get_template_directory_uri() . '/js/scripts.js', 
		array( 'jquery'), // dependencies
	'', // version,
	true
	);

	wp_enqueue_script( 'scrolldepth', 
		get_template_directory_uri() . '/js/analytics/jquery.scrolldepth.js', 
		array( 'jquery'), // dependencies
	'', // version,
	true
	);

	wp_enqueue_script( 'pcomm-analytics', 
		get_template_directory_uri() . '/js/analytics/pcomm-analytics.js', 
		array( 'jquery', 'scrolldepth'), // dependencies
	'', // version,
	true
	);

	// PLEASE NOTE
	// Registering and not enqueing these so we can use modernizr (see footer.php) to load them only where needed

	// included in WordPress core
	wp_register_script( 'json2', 
		'/wp-includes/js/json2.js', 
		array(''), 
	'' );


	wp_register_script( 'placeholder', 
		get_template_directory_uri() . '/js/libs/jquery.placeholder.min.js', 
		array(''), 
	'' );
}

add_action( 'wp_enqueue_scripts', 'pcomm_scripts');

/* 
	This adds all our registered styles and scripts to an array
	which we can then reference and enqueue on the fly via modernizr.load (in the footer)
*/
function registered_scripts( $handles = array() ) {
    global $wp_scripts, $wp_styles;

    foreach ( $wp_scripts->registered as $registered )
        $script_urls[ $registered->handle ] = $registered->src;

    foreach ( $wp_styles->registered as $registered )
        $style_urls[ $registered->handle ] = $registered->src;

    if ( empty( $handles ) ) {

        $handles = array_merge( $wp_scripts->queue, $wp_styles->queue );
        array_values( $handles );

    }

    $output = '';

    foreach ( $handles as $handle ) {

        if ( !empty( $script_urls[ $handle ] ) )
            $output .= $script_urls[ $handle ] . ',';

        if ( !empty( $style_urls[ $handle ] ) )
            $output .= $style_urls[ $handle ] . ',';

    }

    $output = substr( $output, 0, -1 );

    echo $output;

}

/*******************************************************************************
 ** CuSTOMIZE EXCERPTS **
 *******************************************************************************/
if(!function_exists('custom_excerpt_length')) {
	function custom_excerpt_length( $length ) {
	    return 10; //Change this number to any integer you like.
	}
	add_filter( 'excerpt_length', 'custom_excerpt_length' );
}

if(!function_exists('custom_excerpt')) {
	function custom_excerpt($text) {
		global $post;
		return str_replace('[...]', '<a href="'. get_permalink($post->ID) . '">' . '...' . '</a>', $text);
	}
	add_filter('the_excerpt', 'custom_excerpt');
}


/*******************************************************************************
 ** Adds the post type and post name to the body class **
 *******************************************************************************/

function pcomm_add_body_class( $classes )
{
	global $post;

	// gets theme options, set in theme-options.php
	$theme_options = pcomm_get_theme_options();

	// if there's a namespace, add it the body class
	$classes[] = $theme_options['pcomm_theme_namespace'];
		
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '_' . $post->post_name;
	}

	if (is_single() ) {
		foreach((wp_get_post_terms( $post->ID)) as $term) {
			// add category slug to the $classes array
			$classes[] = $term->slug;
		}
		foreach((wp_get_post_categories( $post->ID, array('fields' => 'slugs'))) as $category) {
			// add category slug to the $classes array
			$classes[] = $category;
		}
	}

	return $classes;
}

add_filter( 'body_class', 'pcomm_add_body_class' );


/*******************************************************************************
 ** IMAGE RELATED FUNCTIONS **
 *******************************************************************************/

/* adds images sizes */
/* TODO -> Figure out if we want this in parent theme
	and if so, what sizes do we want 
*/
// add_image_size( 'feature-col-thumb', 100, 56, true);
// add_image_size( 'feature-main-image', 744, 380, true);
// add_image_size( 'feature-single', 744, 195, true);

// // Add secondary feature image functionality
// requires MultiPostThumbnails plugin	
// if (class_exists('MultiPostThumbnails')) {
//     new MultiPostThumbnails(
//         array(
//             'label' => 'Secondary Image',
//             'id' => 'secondary-image',
//             'post_type' => 'post'
//         )
//     );
// }

/* 
to add more sizes, simply copy a line from above 
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example:
<?php the_post_thumbnail( 'feature-med' ); ?>

*/

// Removes width and height attributes from thumbnail images
function remove_thumbnail_dimensions( $html ) {
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	return $html;
}
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

//
function pcomm_image_send_to_editor( $html, $id, $caption, $title, $align, $url, $size, $alt )
{
	add_filter( 'disable_captions', create_function('$a', 'return true;') );
    // Manipulate the HTML
    if (!$align) {
    	$div_align = 'alignleft';
    }
    else {
    	$div_align = $align;
    }

    $html = get_image_tag($id, $alt, $title, $align='none', $size);
    $sizes = wp_get_attachment_image_src( $id, $size);
    $width = $sizes[1];
    $height = $sizes[2];
    $hwstring = 'width="' . $width . '" height="' . $height . '"';

    if ( $url ) {
    	$html = '<a href="' . esc_attr($url) . ' ">' . $html . '</a>';
    }
    if (!$caption) {
    	return '<div id="attachment_' . $id . '" class="wp-attachment align' . $div_align
		. '">'
		. $html // '<img src=' . $url . ' alt=' . $title . ' />'
		. '</div>';
    }
    else {
	    return '<div style="width:' . $width . 'px;" id="attachment_' . $id . '" class="wp-attachment wp-caption align' . $div_align
		. '">'
		. '<a href="' . $url . ' ">'
		// . $html
		. '<img ' . $hwstring . ' src=' . $url . ' alt=' . $title . ' />'
		. '</a>'
		. '<p class="wp-caption-text">'
		. $caption . '</p></div>';
   }
}

add_filter( 'image_send_to_editor', 'pcomm_image_send_to_editor', 12, 8 );

// remove protocol specific urls for image serving
update_option('upload_url_path', '/wp-content/uploads');

// See old parent theme for function related to usage of caption shortcodes
// function is called fixed_img_caption_shortcode
// and was added for both wp_caption and caption shortcodes

// also removed image_tag function, which was run with add_filter('get_image_tag', 'image_tag')


/*******************************************************************************
 ** Remove WordPress logo and links from admin bar **
 *******************************************************************************/

function annointed_admin_bar_remove() {
        global $wp_admin_bar;

        /* Remove WP stuff */
        $wp_admin_bar->remove_menu('wp-logo');
}

add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);


/*******************************************************************************
 ** SIDEBAR FOR THEMES **
 *******************************************************************************/

/* 
 *	Disclaimer and Footnote widget areas are currently used in footer.php
*/

 function pcomm_register_sidebars() {
	register_sidebar(array(
		'id' => 'disclaimer',
		'name' => 'Disclaimer',
		'description' => 'The site disclaimer',
		'before_widget' => '<div id="site-disclaimer" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'id' => 'footnote',
		'name' => 'Site Footnote',
		'description' => 'The site footnote',
		'before_widget' => '<div id="site-footnote" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
}

add_action('widgets_init', 'pcomm_register_sidebars');


/*******************************************************************************
 ** DEBUG MESSAGES ON SCREEN **
 *******************************************************************************/

if ( !function_exists('debug') ) {
	function debug($var = false) {
		echo "\n<pre class=\"debug\" style=\"background: #FFFF99; font-size: 10px;\">\n";
		$var = print_r($var, true);
		echo $var . "\n</pre>\n";
	}
}

/*******************************************************************************
 ** ALPHABETICAL CATALOG **
 *******************************************************************************/
function kia_create_glossary_taxonomy(){
    if(!taxonomy_exists('glossary')){
        register_taxonomy('glossary',array('post'),array(
            'show_ui' => false
        ));
    }
}
add_action('init','kia_create_glossary_taxonomy');

function kia_save_first_letter( $post_id ) {
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    //check location (only run for posts)
    $limitPostTypes = array('post');
    if (!in_array($_POST['post_type'], $limitPostTypes)) 
        return $post_id;

    // Check permissions
    if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;

    // OK, we're authenticated: we need to find and save the data
    $taxonomy = 'glossary';

    //set term as first letter of post title, lower case
    wp_set_post_terms( $post_id, strtolower(substr($_POST['post_title'], 0, 1)), $taxonomy );

    //delete the transient that is storing the alphabet letters
    delete_transient( 'kia_archive_alphabet');
}
add_action( 'save_post', 'kia_save_first_letter' );

function kia_run_once(){

    if ( false === get_transient( 'kia_run_once' ) ) {

        $taxonomy = 'glossary';
        $alphabet = array();

        $posts = get_posts(array('numberposts' => -1) );

        foreach( $posts as $p ) :
        //set term as first letter of post title, lower case
        wp_set_post_terms( $p->ID, strtolower(substr($p->post_title, 0, 1)), $taxonomy );
        endforeach;

        set_transient( 'kia_run_once', 'true' );

    }

}
add_action('init','kia_run_once');

?>