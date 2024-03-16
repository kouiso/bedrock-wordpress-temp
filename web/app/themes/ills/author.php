<?php
/**
* Template author archive
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.1
*/

get_header(); ?>

<!--content-->
<div class="content">
	<div class="container">
		<?php ill_archive_breadcrumb(); ?>
		<!--main-->
		<main>
			<div class="author-main">
				<?php the_archive_title( '<div class="archive-title"><h1><span>','</span></h1></div>' ); ?>
				<?php ill_author_archive(); ?>
				<?php get_template_part( 'content', 'archive' ); ?>
			</div>
		</main>
		<!--end main-->
	</div>
</div>
<!--end content-->

<?php get_footer(); ?>