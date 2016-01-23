<?php

/**
 * Custom metabox to show on all post pages.
 *
 */

class pCommPostMeta {

	public function __construct() {
		
		/* creates meta box for adding tout headline to a post */
		$this->prefix = 'pcomm_';
		$this->pcomm_meta_fields = array(
			array(
				'label'	=> 'Tout headline',
				'desc'	=> 'Optional headline text wherever this appears as a tout.',
				'id'	=> $this->prefix . 'tout_headline',
				'inputtype' => 'text',
				'post_type' => 'post'
			),
			array(
				'label'	=> 'Link redirect',
				'desc'	=> 'Optional URL where the post should redirect to',
				'id'	=> $this->prefix . 'post_redirect',
				'inputtype' => 'text',
				'post_type' => 'post'
			),
			array(
				'label'	=> 'Flash module URL',
				'desc'	=> 'Folder location of Flash HTML file, in wp-content/interactive/ folder. No leading slash necessary. Opens in new window.',
				'id'	=> $this->prefix . 'flash_module',
				'inputtype' => 'text',
				'post_type' => 'post'
			),
			array(
				'label'	=> 'Remove page sidebar?',
				'desc'	=> 'Any value (yes, true, uh-huh) will remove the sidebar',
				'id'	=> $this->prefix . 'sidebar_off',
				'inputtype' => 'text',
				'post_type' => 'page'
			)
		);

		// creates the post meta box
		add_action( 'add_meta_boxes', array( $this, 'pcomm_add_meta_box' ) );

		// saves the meta box contents on save
		add_action( 'save_post', array( $this, 'pcomm_save_metabox_details' ) );


	}

	public function pcomm_postmeta() {
		global $post;
		// $custom = get_post_custom($post->ID);
		// $tout_headline = $custom["tout_headline"][0];
		echo '<input type="hidden" name="pcomm_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		?>
		<ul>
			<?php foreach ($this->pcomm_meta_fields as $field) {
				if ( get_post_type() === $field['post_type'] ) {
					// get value of this field if it exists for this post
					$meta = get_post_meta($post->ID, $field['id'], true);
					$desc = '';

					if ($field['desc'] != '') {
						$desc = '<span style="font-style: italic; color: #999;">' . $field['desc'] . '</span>';
					}
					if ($field['type'] == 'select') {
						echo '<li class="'. $prefix . 'repeatable"><label style="display:block; font-weight: bold; margin-top: 1em;" for="' . $field['id'] . '">' . $field['label'] . '</label>';
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';  
						foreach ($field['options'] as $option) {  
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';  
						}
						echo '</select>' . $desc .'</li>';  
					}
					else if ($meta && is_array($meta)) {
						foreach($meta as $row) {
							echo '<li class="'. $prefix . 'repeatable"><label style="display:block; font-weight: bold; margin-top: 1em;" for="' . $field['id'] . '">' . $field['label'] . '</label>';
							echo '<input type="'.$field['inputtype'].'" name="'.$field['id'].'" id="'.$field['id'].'" value="' . $row . '" size="30" />' . $desc . '</li>';
						}
					}
					else {
						echo '<li class="'. $prefix . 'repeatable"><label style="display:block; font-weight: bold; margin-top: 1em;" for="' . $field['id'] . '">' . $field['label'] . '</label>';
						echo '<input type="'.$field['inputtype'].'" name="'.$field['id'].'" id="'.$field['id'].'" value="' . $meta . '" size="30" />' . $desc . '</li>';
					}
				}
			}
			?>
			
		</ul>
		<?php
	}

	// add the meta box to our contact posts
	public function pcomm_add_meta_box() {
		add_meta_box( "post_meta", "PartnerComm extras", array($this,"pcomm_postmeta"), "post", "normal", "high" );
		add_meta_box( "post_meta", "PartnerComm extras", array($this,"pcomm_postmeta"), "page", "normal", "high" );
	}


	// Save the Data
	public function pcomm_save_metabox_details($post_id) {
		global $post;
		// verify nonce
		if ( !wp_verify_nonce($_POST['pcomm_meta_box_nonce'], basename(__FILE__))) 
			return $post_id;
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post_id;
		// check permissions
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id))
				return $post_id;
			} elseif (!current_user_can('edit_post', $post_id)) {
				return $post_id;
		}
		
		// loop through fields and save the data
		foreach ($this->pcomm_meta_fields as $field) {
			
			$old = get_post_meta($post_id, $field['id'], true);
			if (isset($_POST[$field['id']])) {
				$new = $_POST[$field['id']];
				if ($new && $new != $old) {
					update_post_meta($post_id, $field['id'], $new);
				} elseif ('' == $_POST[$field['id']] && $old) {
					delete_post_meta($post_id, $field['id'], $old);
				}
			}
			else {
				delete_post_meta($post_id, $field['id'], $old);
			}
		} // end foreach
		
	}

}
$pCommPostMeta = new pCommPostMeta();

?>