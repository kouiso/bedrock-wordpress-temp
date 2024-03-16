<?php
/**
* Thumb
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
*/
?>
<!--thumbnail-->
<?php if ( has_post_thumbnail() ): ?>
<div class="eye-catch">
	<a class="image-link-border" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'small-thumbnail' ); ?></a>
<?php illn_entry_meta_category(); ?>
</div>
<?php else: ?>
<div class="eye-catch">
	<a class="image-link-border" href="<?php the_permalink(); ?>"><img width="431" height="208" src="<?php echo get_template_directory_uri(); ?>/lib/images/no-img/small-no-img.png" alt="no image" /></a>
<?php illn_entry_meta_category(); ?>
</div>
<?php endif; ?>
<!--end thumbnail-->