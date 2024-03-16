<?php
/**
* Template 404 pages (Not Found)
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
*/

get_header(); ?>

<section class="l-content">
  <div class="l-notfound">
    <h2 class="l-notfound-text">404</h2>
    <p class="l-notfound-text">お探しのページは見つかりません。<br class="sp-404">一時的にアクセス出来ない状態か、<br class="pc-404">移動もしくは<br class="sp-404">削除されてしまった可能性があります。</p>
    <p class="l-notfound-text">The page you are looking for is not found. Is temporarily inaccessible,<br>It may have been moved or deleted.</p>
    <a class="button" href="/">トップページへ戻る</a>
  </div>
</section>

<?php
    global $wpdb;
    $result = $wpdb->get_results(
        "SELECT * FROM reserves"
    );

    foreach($result as $item){
        echo $item->id;
        echo $item->name;
        echo $item->email;
        echo $item->tel;
        echo $item->address;
        echo $item->question;
        echo $item->inquery;
        echo $item->reserve_dt;
    };
?>

<?php get_footer(); ?>
