<?php
/**
 * @package _s
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-meta">
			<?php pcomm_posted_on_date(); ?>
		</div><!-- .entry-meta -->
		<h2 class="entry-title"><?php the_title(); ?></h2>
	</header><!-- .entry-header -->

	<?php 
		if ( has_post_thumbnail() && !in_array("noimage", $tag_array)) {
			echo '<div class="page-image">';
			the_post_thumbnail();
			echo '</div>';
		}
	?>
	
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . 'Pages:',
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
