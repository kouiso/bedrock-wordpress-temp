<?php
/**
* Template Name: お知らせ
* @package WordPress
* @Template Post Type: post, page,
* @subpackage I'LL
* @since I'LL 1.0
*/

get_header(); ?>
<!--content-->


<!--MV-->
<div class="page__mv about hero">
  <p class="page__mv--text">お知らせ</p>
</div>
<!--MV END-->


<!--NEWS-->
<section class="page__news">
  <div class="article-inner">
    
    <!--    <h2>NEWS</h2>-->
    
    <ul class="page__news--list foo" data-delighter>
      <?php
        $args = array(
           'post_type' => 'news', /* 投稿タイプ */
           'paged' => $paged,
           'order' => 'DESC',
           'posts_per_page' => 2 /* 記事3つ */
        );
        query_posts( $args );
        if (have_posts()) :
          while (have_posts()) : the_post();
      ?>
      <li class="page__news--list--text">
        <a class="txt-box" href="<?php the_permalink(); ?>">
        <div class="txt-box">
          <time><?php the_time('Y/m/d'); ?></time>
          
          <div>
              <?php the_title(); ?>
<!--              <?php the_content(); ?>-->
          </div>
        </div>
        </a>
      </li>
      <?php
        endwhile;
        endif;
      ?>
      <?php if( function_exists("the_pagination") ) the_pagination(); ?>
    </ul>
  </div>
</section>
<!--NEWS-->

<!--end content-->
<?php get_footer(); ?>
