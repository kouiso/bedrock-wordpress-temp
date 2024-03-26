<?php
/**
* Template archive pages
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
*/

get_header(); ?>

<!--content-->
<div class="content">
	<div class="container">
		<?php ill_archive_breadcrumb(); ?>
		<!--main-->
		<main>
			<div class="archive-main">
				<?php if ( is_404() ) : ?>
				<div class="archive-title"><h1><span><?php _e( '404 File not found.', 'ill' ); ?></span></h1></div>
				<?php elseif ( is_search() ) : ?>
				<div class="archive-title"><h1><span><?php _e( 'Search Word', 'ill' ); ?><?php the_search_query(); ?><i class="fa fa-angle-right"></i><?php echo $wp_query->found_posts; ?><?php _e( 'Number', 'ill' ); ?></span></h1></div>
				<?php else: ?>
				<?php the_archive_title( '<div class="archive-title"><h1><span>','</span></h1></div>' ); ?>
				<?php if ( !is_paged() ) : ?>
				<div class="archive-description">
					<p><?php ill_archive_description(); ?></p>
				</div>
				<?php endif; ?>
				<?php endif; ?>
				<?php
					if ( is_404() ) {
					$name = 'none';
						} elseif ( is_search() ){
					$name = 'search';
						} else {
					$name = 'archive';
					}
					get_template_part( 'content', $name );
				?>
			</div>
		</main>
		<!--end main-->
	</div>
</div>
<!--end content-->

<?php get_footer(); ?>