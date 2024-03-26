<?php
/**
* Template Page
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
*/

get_header(); ?>
<!--Page-->
<article class="article content-page">
	<?php while ( have_posts() ) : the_post(); ?>
	<header>
		<!--記事のタイトルを出力-->
		<div class="article-header">
			<h1><?php the_title(); ?><?php ill_subtitle(); ?><?php edit_post_link( __( 'Edit', 'ill' ), '<span class="edit-link"><i class="fa fa-pencil-square-o"></i>', '</span>' ); ?></h1>
		</div>
		<!--サムネイルを設定したらサムネイルを出力-->
		<?php if( has_post_thumbnail() && $page_thumbnail_layout != 'no_display' && ! $none_display_thumbnail ): ?>
		<div class="article-thumbnail">
			<?php the_post_thumbnail( 'large-thumbnail' ); ?>
		</div>
		<?php endif; ?>
	</header>
	<!--コンテンツ-->
	<section class="article-body">
	<?php the_content(); ?>
	</section>
	<?php if ( $display_mobile_footer_page && is_mobile() ): ?>
		<?php ill_mobile_footer_buttons_page(); ?>
		<?php ill_mobile_footer_buttons_modal_window(); ?>
	<?php endif; ?>
	<?php endwhile; ?>
</article>
<!--End Page-->
<?php get_footer(); ?>