<?php
/**
* Main template
* @package WordPress
* @subpackage I'LL
* @since I'LL Pro 1.0
*/

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

    <?php
    if ( have_posts() ) :

        while ( have_posts() ) : the_post();
            the_title('<h1>', '</h1>');
            the_content();
        endwhile;

    else :

        echo '<p>No posts found.</p>';

    endif;
    ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
