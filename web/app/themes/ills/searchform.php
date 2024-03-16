<?php
/**
* Template for displaying search forms
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.8
*/
?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $unique_id; ?>">
	</label>
	<input type="search" id="<?php echo $unique_id; ?>" class="search-field" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
</form>
