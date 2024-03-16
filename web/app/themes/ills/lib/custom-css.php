<?php
/**
* Theme inline style
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
* 
* 特定のページにのみ適用されるカスタムCSSの設定
*/
function ill_custom_css() {
	/*--page custom css--*/
	$ill_custom_css_setting = post_custom( 'ill_custom_css_setting' );
?>

<style>
	<?php echo $ill_custom_css_setting; ?>
</style>

<?php
}
add_action( 'wp_head', 'ill_custom_css' );