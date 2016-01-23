<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
?>

<div class="no-results not-found">
	<h1 class="page-title">Nothing found</h1>

	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		<p>Ready to publish your first post? <a href="<?php esc_url( admin_url( 'post-new.php' ) ); ?>">Get started here</a></p>

	<?php elseif ( is_search() ) : ?>

		<p>Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>

	<?php else : ?>

		<p>It seems we can't find what you're looking for. Sorry.</p>

	<?php endif; ?>
</div><!-- .no-results -->
