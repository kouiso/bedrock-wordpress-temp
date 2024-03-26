<?php
/**
* Template Name: アクセス
* @package WordPress
* @Template Post Type: post, page,
* @subpackage I'LL
* @since I'LL 1.0
*/

get_header(); ?>
<!--content-->
<!--MV-->
<div class="page__mv access hero">
  <p class="page__mv--text">アクセス</p>
</div>
<!--MV END-->

<!--CONTENT-->
<section class="page__content access__page">
  <div class="inner access__flex">
    <figure class="page__content--access--img js-trigger fade-type-scale"><img src="/wp-content/uploads/img05.jpg" alt="画像"></figure>
    <article class="page__content--access--box js-trigger fade-type-scale">
      <dl class="access__page--table">

        <dt>住所</dt>
        <dd>〒333-0847 埼玉県川口市芝中田2-8-28</dd>

        <dt>電話</dt>
        <dd>048-263-2201</dd>

        <dt>アクセス</dt>
        <dd>JR京浜東北線　蕨駅東口徒歩１０分</dd>
        <dt>定休日</dt>
        <dd>日曜日</dd>
      </dl>
    </article>


  </div>
  <div class="gmap-wrap">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3234.826031397198!2d139.6994045505909!3d35.828743829378105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x601894c61c3ac823%3A0xdac6e0e849afca18!2z5b-X6Zm96aSo!5e0!3m2!1sja!2sjp!4v1605775446037!5m2!1sja!2sjp" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
  </div>
</section>
<!--CONTENT END-->

<?php get_footer(); ?>
