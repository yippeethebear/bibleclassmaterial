<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 */

get_header(); ?>

	<div id="content" class="container">
		<div class="layout">
					
			<section class="page-content error-404">
				
				<h1 class="page-title">Page not found</h1>

				<p>It looks like nothing was found at this location. Maybe try a search?</p>

				<?php get_search_form(); ?>

				<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

			</section><!-- .error-404 -->

		</div><!-- .layout -->
	</div><!-- .container -->

<?php get_footer(); ?>