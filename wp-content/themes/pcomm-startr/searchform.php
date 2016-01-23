<?php
/* 
 * Adapted modern markup from Automattic's underscores theme:
 * https://github.com/Automattic/_s/blob/master/searchform.php 
*/
?>
<div class="search-wrap">
	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	    <label>
	        <span class="screen-reader-text">Search for:</span>
	        <input type="search" class="search-field" placeholder="Search &hellip;" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	    </label>
	    <input type="submit" class="search-submit" value="Search">
	</form>
</div>