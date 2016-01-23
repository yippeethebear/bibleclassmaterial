<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?>
<?php
 	$headline = get_page_by_path('headlines',OBJECT,'post');
?>

<div class="index-contain">
	<div class="headers">
		<h1><?php echo $headlines->post_title; ?></h1>
		<h4><?php echo $headlines->post_content; ?></h4>
	</div>

	<div class="home-tiles">
		<?php
			$home_query = new WP_Query(array(
				'tag' => 'home-tile'
			));

			if ($home_query->have_posts() ): ?>
			<ul>
			<?php while ($home_query->have_posts()): $home_query->the_post(); ?>
				<li><a class="middle"><?php the_title(); ?></a></li>
			<?php endwhile; endif; ?>
	</div>
</div>

<?php get_footer(); ?>
