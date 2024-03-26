<?php
/**
* Twitter Card
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
*/
?>
<!--twitter card-->
<meta name="twitter:card" content="<?php echo esc_attr( get_ill_twitter_card_type() ); ?>">
<meta name="twitter:site" content="<?php echo esc_html( get_ill_twitter_id() ); ?>">
<meta name="twitter:title" content="<?php ill_opg_title(); ?>">
<meta name="twitter:description" content="<?php ill_description(); ?>" />
<?php ill_twitter_opg_image( ); ?>
<!--end twitter card-->
