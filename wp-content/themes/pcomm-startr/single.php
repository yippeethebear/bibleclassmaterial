<?php
/**
 * The Template for displaying all single posts.
 *
 */

get_header(); ?>
<div class="wrapper">
	<div id="content" class="container">
			
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>

	</div><!-- .container -->
</div>
<?php get_footer(); ?>
