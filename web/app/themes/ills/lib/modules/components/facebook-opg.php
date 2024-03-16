<?php
/**
* Facebook OGP
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
* Learn more: https://developers.facebook.com/docs/sharing/webmasters
*/
?>
<!--opg-->
<meta property="og:title" content="<?php ill_opg_title(); ?>">
<meta property="og:type" content="<?php if($_SERVER[ "REQUEST_URI" ] == "/"){ ?>website<?php } else { ?>article<?php }?>">
<meta property="og:url" content="<?php ill_ogp_url(); ?>" >
<?php ill_facebook_opg_image(); ?>
<?php if ( empty( $post->post_password ) ) : ?>
<meta property="og:description" content="<?php ill_description(); ?>">
<?php endif; ?>
<meta property="og:locale" content="ja_JP">
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>">
<?php if ( get_ill_facebook_app_id() ): ?>
<meta property="fb:app_id" content="<?php echo esc_html( get_ill_facebook_app_id() ); ?>" >
<?php endif; ?>
<!--end opg-->
