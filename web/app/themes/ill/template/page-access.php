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
  <p class="page__mv--text">[AccessTitle]</p>
</div>
<!--MV END-->

<!--CONTENT-->
<section class="page__content access__page">
  <div class="inner access__flex">
    <figure class="page__content--access--img js-trigger fade-type-scale"><img src="[AccessImage]" alt="[AccessImageAlt]"></figure>
    <article class="page__content--access--box js-trigger fade-type-scale">
      <dl class="access__page--table">

        <dt>[AddressTitle]</dt>
        <dd>[Address]</dd>

        <dt>[PhoneTitle]</dt>
        <dd>[PhoneNumber]</dd>

        <dt>[AccessTitle]</dt>
        <dd>[AccessDetails]</dd>
        <dt>[HolidayTitle]</dt>
        <dd>[HolidayDetails]</dd>
      </dl>
    </article>


  </div>
  <div class="gmap-wrap">
      <iframe src="[GoogleMapLink]" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
  </div>
</section>
<!--CONTENT END-->

<?php get_footer(); ?>
