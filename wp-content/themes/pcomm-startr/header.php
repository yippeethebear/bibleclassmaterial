<!doctype html>  

<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?>class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6 oldie"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7 oldie"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8 oldie"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
	
	<head>
		<meta charset="utf-8">
		<meta name="robots" content="noindex, nofollow">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
		
		wp_title( '-', true, 'right' );
		
		// Add the blog name.
		bloginfo( 'name' );
		
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " - $site_description";
		
		?></title>
		
		<meta name="description" content="<?php echo $site_description; ?>">
		
		<!-- mobile optimized -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0">
		<!-- IE6 toolbar removal -->
		<meta http-equiv="imagetoolbar" content="false" />
		<!-- allow pinned sites -->
		<meta name="application-name" content="<?php bloginfo('name'); ?>" />
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		
		<!-- start wp_head -->
		<?php wp_head(); ?>
		<!-- end wp head -->
		<!--[if (gte IE 6)&(lte IE 8)]>
			<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/libs/selectivizr.js"></script>
		<![endif]-->
		
		<?php
			$theme_options = pcomm_get_theme_options();
			
		?>	
	</head>
	
	<body <?php body_class(); ?>>
		<div class="top-wrapper">
			<header role="banner">
				<h1 class="logo"><a href="/"><?php echo bloginfo( 'name' ); ?></a></h1>
			</header> <!-- end header -->
			<div class="page-nav">
				<div class="nav-wrap">
					<nav id="sticky_navigation" class="menu main-navigation" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false ) ); ?>
					</nav>
				</div>
			</div>
		</div>