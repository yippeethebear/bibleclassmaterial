<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 */

if ( ! function_exists( 'pcomm_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @return void
	 */
	function pcomm_paging_nav() {
	        // Don't print empty markup if there's only one page.
	        if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
	                return;
	        }
	        ?>
	        <nav class="navigation paging-navigation" role="navigation">
                <h1 class="screen-reader-text">Posts navigation</h1>
                <div class="nav-links">

                        <?php if ( get_next_posts_link() ) : ?>
                        <div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span> Older posts' ); ?></div>
                        <?php endif; ?>

                        <?php if ( get_previous_posts_link() ) : ?>
                        <div class="nav-next"><?php previous_posts_link(  'Newer posts <span class="meta-nav">&rarr;</span>' ); ?></div>
                        <?php endif; ?>

                </div><!-- .nav-links -->
	        </nav><!-- .navigation -->
	        <?php
	}
endif;

if ( ! function_exists( 'pcomm_paging_search_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @return void
	 */
	function pcomm_paging_search_nav() {
	        // Don't print empty markup if there's only one page.
	        if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
	                return;
	        }
	        ?>
	        <nav class="navigation paging-navigation" role="navigation">
                <h1 class="screen-reader-text">Posts navigation</h1>
                <div class="nav-links">

                         <?php if ( get_previous_posts_link() ) : ?>
                        	<?php previous_posts_link(  '<span class="meta-nav">&larr;</span> Previous' ); ?>
                        <?php endif; ?>

                        <?php if ( get_next_posts_link() && get_previous_posts_link() ) : ?>
							|
						<?php endif; ?>

						<?php if ( get_next_posts_link() ) : ?>
                        	<?php next_posts_link( 'Next <span class="meta-nav">&rarr;</span> ' ); ?>
                        <?php endif; ?>

                </div><!-- .nav-links -->
	        </nav><!-- .navigation -->
	        <?php
	}
endif;

if ( ! function_exists( 'pcomm_posted_on_date' ) ) :
	
	/* returns time element with published date of post */
	function pcomm_posted_on_date() {
		printf( __( '<time class="entry-date" datetime="%1$s" pubdate>%2$s</time>', 'pcomm' ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
	}

endif;


	/**
	 * Returns true if a blog has more than 1 category.
	 * Taken from Automattics's underscores theme
	 */
	function pcomm_categorized_blog() {
        if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
                // Create an array of all the categories that are attached to posts.
                $all_the_cool_cats = get_categories( array(
                    'hide_empty' => 1,
                ) );

                // Count the number of categories that are attached to the posts.
                $all_the_cool_cats = count( $all_the_cool_cats );

                set_transient( 'all_the_cool_cats', $all_the_cool_cats );
        }

        if ( '1' != $all_the_cool_cats ) {
                // This blog has more than 1 category so _s_categorized_blog should return true.
                return true;
        } else {
                // This blog has only 1 category so _s_categorized_blog should return false.
                return false;
        }
	}


	/**
	 * Flush out the transients used in _s_categorized_blog.
	 */
	function pcomm_category_transient_flusher() {
        // Like, beat it. Dig?
        delete_transient( 'all_the_cool_cats' );
	}
	
	add_action( 'edit_category', 'pcomm_category_transient_flusher' );
	add_action( 'save_post',     'pcomm_category_transient_flusher' );


if ( ! function_exists( 'pcomm_tout_headline' ) ) :

	/* pulls a custom tout headline if it exists */
	function pcomm_tout_headline() {
		global $post;

		$tout_headline = get_post_meta($post->ID, 'pcomm_tout_headline', TRUE);

		if ($tout_headline != '') {
			return $tout_headline;
		}
		else {
			return get_the_title();
		}
	}
endif;

if ( ! function_exists( 'pcomm_post_permalink' ) ) :
	/* pulls a redirect URL if it exists */
	function pcomm_post_permalink($get_tag, $blank) {
		global $post;

		$post_redirect = get_post_meta($post->ID, 'pcomm_post_redirect', TRUE);
		$flash_module = get_post_meta($post->ID, 'pcomm_flash_module', TRUE);
		$target = '';
		if ($blank) {
			$target = ' target="_blank"';
		}

		if ($post_redirect != '') {

			$permalink = $post_redirect;
		}
		if ($flash_module != '') {
			$permalink = '/wp-content/interactive/' . $flash_module;
		}	

		if ($get_tag) {
			if ($post_redirect != '' || $flash_module != '') {
				if ($flash_module != '' || preg_match('/https?:/', $post_redirect)) {
					$target = ' target="_blank"';

				}	
				echo '<a' . $target . ' href="' . $permalink . '">';
			}
			else {
				echo '<a' . $target . ' href="' . get_permalink() . '">';
			}
		}
		else {
			if ($post_redirect != '' || $flash_module != '') {
				return $permalink;
			}
			else {
				return get_permalink();
			}
		}
	}
endif;

if ( ! function_exists( 'pcomm_comments' ) ) :
/* 
	Comment Layout
*/
function pcomm_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php echo get_avatar($comment,$size='32' ); ?>
				<p class="vcard-head">Comment from:</p>
				<?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
				<?php $timestamp = strtotime(get_comment_date());?>
				<?php $date_string = date('M n, Y', $timestamp);?>
				<time><?php echo $date_string;?></time>
				<?php edit_comment_link(__('(Edit)'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="help">
					<p><?php _e('Your comment is awaiting moderation.') ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
	<!-- </li> is added by wordpress automatically -->
	<?php
}
endif;

if ( ! function_exists( 'pcomm_get_post_pdf' ) ) :

/* get attached pdf files for post 
this only gets the first PDF attached to the current post */
function pcomm_get_post_pdf() {
	global $post;

	$attachments = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'application/pdf', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
	
	if ($attachments) { 
		$attachment = array_shift($attachments);
		return wp_get_attachment_url($attachment->ID);
	}
	
	return false;
}
endif;


if ( ! function_exists( 'pcomm_page_sidebar' ) ) :
	/* determines if a page has a sidebar turned on or off */
	function pcomm_page_sidebar() {
		global $post;

		$page_sidebar = get_post_meta($post->ID, 'pcomm_page_sidebar', TRUE);

		if ($page_sidebar != '') {
			return 'page_sidebar';
		}
		else {
			return '';
		}
	}
endif;

?>