<?php
/**
* Template single news
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
* カスタム投稿タイプ「ニュース」用のテンプレート
*/

get_header(); ?>
<!--SinglePage-->

<!--MV-->
<div class="page__mv about hero">
  <p class="page__mv--text">お知らせ</p>
</div>
<!--MV END-->

<article class="article-content article content-page article-inner">
  
  <!--  <h2>お知らせ</h2>-->
  
  <?php while ( have_posts() ) : the_post(); ?>

  <section class="article-body">

    <p class="article-body_ttl"><?php the_title(); ?></p>

    <div class="article_font">
    <?php the_content(); ?>
    </div>
    
  </section>
  
  <?php if ( $display_mobile_footer_page && is_mobile() ): ?>
      <?php extrapress_mobile_footer_buttons_page(); ?>
      <?php extrapress_mobile_footer_buttons_modal_window(); ?>
  <?php endif; ?>
  <?php endwhile; ?>
  
</article>
<!--End SinglePage-->
<?php get_footer(); ?>

