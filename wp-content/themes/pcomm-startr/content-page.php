<?php
/**
 * The template used for displaying page content in page.php
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- h2 class="entry-title"><?php the_title(); ?></h2 -->

	<div class="entry-content">
		<?php 
			echo '<div class="intro">';
			the_content();
			echo '</div>';

		?>
		<?php 
			if ( has_post_thumbnail() && !in_array("noimage", $tag_array)) {
				echo '<div class="page-image">';
				the_post_thumbnail();
				echo '</div>';
			}
		?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . 'Pages:',
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
