<?php
/**
* Template Name: About
* @package WordPress
* @Template Post Type: post, page,
* @subpackage I'LL
* @since I'LL 1.0
*/

get_header(); ?>
<!--content-->
<!--MV-->
<div class="page__mv about hero">
  <p class="page__mv--text">[AboutTitle]</p>
</div>
<!--MV END-->

<!--CONTENT-->
<section class="page__about">
  <div class="inner">
    <div class="page__about--box1">
      <h2>[PurposeTitle]</h2>
      <p>[PurposeSubtitle]</p>
      <p>
        [PurposeContent1]
        <br>
        <br>
        [PurposeContent2]
        <br>
        <br>
        [PurposeContent3]
      </p>
      <p>[OrganizationName]</p>
    </div>

    <div class="page__about--box2">
      <h2>[DojoRulesTitle]</h2>
      <p>1.[Rule1]</p>
      <p>2.[Rule2]</p>
      <p>3.[Rule3]</p>
      <p>4.[Rule4]</p>
    </div>

  </div>
</section>
<!--CONTENT END-->

<!--CONTACT END-->
<!--end content-->
<?php get_footer(); ?>
