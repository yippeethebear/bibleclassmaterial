<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 */

get_header(); ?>

<section role="main">
	<div id="content" class="container">
		<div class="layout">
			<h1 class="page-title"><?php the_title(); ?></h1>
			<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
				<div><input type="text" size="18" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
				<input type="submit" id="searchsubmit" value="Search" class="btn" />
				</div>
			</form>
			<?php $catalog_query = new WP_Query(array(
				'category_name' => 'catalog'
				)); ?>
			<?php if ( $catalog_query->have_posts()): ?>
			
			<?php $taxonomy = 'glossary';

			// save the terms that have posts in an array as a transient
			if ( false === ( $alphabet = get_transient( 'kia_archive_alphabet' ) ) ) {
			    // It wasn't there, so regenerate the data and save the transient
			    $terms = get_terms($taxonomy);

			    $alphabet = array();
			    if($terms){
			        foreach ($terms as $term){
			            $alphabet[] = $term->slug;
			        }
			    }
			    set_transient( 'kia_archive_alphabet', $alphabet );
			}

			?>

			<div id="archive-menu" class="menu">

			    <ul id="alphabet-menu">

			    <?php

			    foreach(range('a', 'z') as $i) :

			        $current = ($i == get_query_var($taxonomy)) ? "current-menu-item" : "menu-item";

			        if (in_array( $i, $alphabet )){
			            printf( '<li class="az-char %s"><a href="%s">%s</a></li>', $current, get_term_link( $i, $taxonomy ), strtoupper($i) );
			        } else {
			            printf( '<li class="az-char %s">%s</li>', $current, strtoupper($i) );
			        }

			    endforeach;

			    ?>
			    </ul>

			</div>

			<!-- <div class="letter-center">
				<ul class="letter-nav">
					<li>A</li>
					<li>B</li>
					<li>C</li>
					<li>D</li>
					<li>E</li>
					<li>F</li>
					<li>G</li>
					<li>H</li>
					<li>I</li>
					<li>J</li>
					<li>K</li>
					<li>L</li>
					<li>M</li>
					<li>N</li>
					<li>O</li>
					<li>P</li>
					<li>Q</li>
					<li>R</li>
					<li>S</li>
					<li>T</li>
					<li>U</li>
					<li>V</li>
					<li>W</li>
					<li>X</li>
					<li>Y</li>
					<li>Z</li>
				</ul>
			</div> -->
			<?php while ( $catalog_query->have_posts() ) : $catalog_query->the_post(); ?>
				<?php global $post; ?>
				<?php $author = get_post_meta($post->ID,'author',true); ?>
				<a href="<?php the_permalink(); ?>" class="catalog-link"><p class="catalog-item"><?php the_title(); ?> - <span><?php echo($author); ?></span></p></a>
				

			<?php endwhile; endif; // end of the loop. ?>
			<ul>
				<li>Things</li>
				<li>Things</li>
				<li>Things</li>
				<li>Things</li>
				<li>Things</li>
				<li>Things</li>
				<li>Things</li>
				<li>Things</li>
				<li>Things</li>
				<li>Things</li>
				<li>Things</li>
				<li>Things</li>
				<li>Things</li>
				<li>Things</li>
				<li>Things</li>
			</ul>
		</div><!-- .layout -->
	</div><!-- .container -->
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
