<?php
/**
* Content none
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
*/
?>
<!--article-->
<article class="article">
	<header class="article-header">
		<h1><?php _e( 'Oops! That page cannot be found.', 'ill' ); ?></h1>
		<p><?php _e( 'The page you were trying to access does not exist or has been removed. Maybe check URL or Find page again from the following methods.', 'ill' ); ?></p>
	</header>
	<section class="article-body">
		<h2><?php _e( 'Find page in search box.', 'ill' ); ?></h2>
		<p><?php _e( 'Enter the keyword related to entry looking for in the search box.', 'ill' ); ?></p>
		<?php get_search_form(); ?>
		<h3><?php _e( 'Find page from the category list.', 'ill' ); ?></h3>
		<ul>
		<?php $args = array(
			'title_li' => '',
		); ?>
		<?php wp_list_categories( $args ); ?>
		</ul>
	</section>
</article>
<!--end article-->
