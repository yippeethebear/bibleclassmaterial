<?php
/**
 * The template for displaying Search Results pages.
 *
 */

get_header(); ?>

	<div id="content" class="container">
		<div class="layout">

		<?php if ( have_posts() ) : ?>

			<h1 class="page-title"><?php printf( 'Search results for: %s', '<span>' . get_search_query() . '</span>' ); ?></h1>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'search' ); ?>

			<?php endwhile; ?>

			<?php pcomm_paging_search_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</div><!-- .layout -->
	</div><!-- .container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>