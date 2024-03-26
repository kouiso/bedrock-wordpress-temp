<?php
/**
* Template header
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
*/
?>
<!DOCTYPE html>
<?php session_start(); ?>
<html <?php language_attributes(); ?> dir="ltr">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <?php endif; ?>
  <?php wp_head(); ?>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
</head>

<body id="top" <?php body_class(); ?>>
  <header class="l--header">
    <div class="inner flex">
      <a href="/" class="logo">
<!--        <a href="/"><img src="/wp-content/uploads/logo.png" alt="ロゴ"></a>-->
      </a>
      <button type="button" id="js-buttonHamburger" class="l--header__button p--hamburger" aria-controls="global-nav" aria-expanded="false">
        <span class="p--hamburger__line">
          <span class="u--visuallyHidden">
            メニューを開閉する
          </span>
        </span>
      </button>
      <nav class="gnav">
        <div class="gnav__wrap">
          <ul class="gnav__menu">
            <li class="gnav__menu__item"><a href="/">HOME</a></li>
            <li class="gnav__menu__item"><a href="/about/">志陽館について</a></li>
<!--            <li class="gnav__menu__item"><a href="/menu/">料金メニュー</a></li>-->
            <li class="gnav__menu__item"><a href="/info/">武道って？</a></li>
            <li class="gnav__menu__item"><a href="/access/">アクセス</a></li>
            <li class="gnav__menu__item"><a href="/join/">ご入会の案内</a></li>
            <li class="gnav__menu__item"><a href="/news/">お知らせ</a></li>
<!-- 			  <li class="gnav__menu__item"><a href="/calendar/">カレンダー</a></li> -->

            <li class="gnav__menu__item"><a href="/contact/">お問い合わせ</a></li>
          </ul>
        </div>
        <!--gnav-wrap-->
      </nav>
    </div>

  </header>
  
 