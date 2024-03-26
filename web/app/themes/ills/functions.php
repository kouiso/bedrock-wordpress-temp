<?php
/**
* I'LL function
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
*/

/*------------------------------------------------------------------------------------
/* テーマオプションの読み込み
/*----------------------------------------------------------------------------------*/
require_once ( get_template_directory() . '/lib/theme-admin-options.php' );
require_once ( get_template_directory() . '/lib/theme-customizer.php' );
require_once ( get_template_directory() . '/lib/theme-tags.php' );
require_once ( get_template_directory() . '/lib/tinymce/inserthtml/add_insert_html_button.php' );
require_once ( get_template_directory() . '/lib/custom-css.php' );

/*------------------------------------------------------------------------------------
/* WordPress標準の機能
/*----------------------------------------------------------------------------------*/
if ( !isset( $content_width ) ) {
  $content_width = 1118;
}

if ( !function_exists( 'ill_setup' ) ):
function ill_setup() {
  load_theme_textdomain( 'ill', get_template_directory() . '/languages' );
  add_theme_support( 'title-tag' );
  add_theme_support( 'customize-selective-refresh-widgets' );
  //メニューの位置
  register_nav_menu( 'global-nav', __( 'グローバルナビ' ) );
  register_nav_menu( 'hamburger-menu', __( 'ハンバーガーメニュー' ) );
  //画像のサイズ
  add_theme_support( 'post-thumbnails' );
  add_image_size( 'large-thumbnail', 1118, 538, true );
  add_image_size( 'middle-thumbnail', 1016, 300, true );
  add_image_size( 'slider-thumbnail', 733, 353, true );
  add_image_size( 'small-thumbnail', 544, 262, true );
  add_image_size( 'square-thumbnail', 180, 180, true );
}
add_action( 'after_setup_theme', 'ill_setup' );
endif;

//ダッシュボード デフォルトのサイドメニューの非表示
function remove_menus () {
    global $menu;
    unset($menu[25]); // コメント
}
add_action('admin_menu', 'remove_menus');


/*------------------------------------------------------------------------------------
/* スタイルシート
/*----------------------------------------------------------------------------------*/

//CSS追加
function my_child_styles() {
  wp_enqueue_style( 'main', get_stylesheet_directory_uri() . '/lib/css/main.css', array(), '1.0.3' );
  wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . '/lib/css/font-awesome.min.css', array(), '1.0.3' );
  wp_enqueue_style( 'reset', get_stylesheet_directory_uri() . '/lib/css/reset.css', array(), '1.0.3' );
  wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/lib/css/style.css', array(), '1.0.3' );
  wp_enqueue_style( 'fade-in', get_stylesheet_directory_uri() . '/lib/css/fade-in.css', array(), '1.0.3' );
  wp_enqueue_style( 'loaders', get_stylesheet_directory_uri() . '/lib/css/loaders.css', array(), '1.0.3' );
  wp_enqueue_style( 'header', get_stylesheet_directory_uri() . '/lib/css/header.css', array(), '1.0.3' );
  wp_enqueue_style( 'footer', get_stylesheet_directory_uri() . '/lib/css/footer.css', array(), '1.0.3' );
  wp_enqueue_style( 'top', get_stylesheet_directory_uri() . '/lib/css/top.css', array(), '1.0.3' );
  wp_enqueue_style( 'page', get_stylesheet_directory_uri() . '/lib/css/page.css', array(), '1.0.3' );
  wp_enqueue_style( 'page-about', get_stylesheet_directory_uri() . '/lib/css/page-about.css', array(), '1.0.3' );
	wp_enqueue_style( 'page-access', get_stylesheet_directory_uri() . '/lib/css/page-access.css', array(), '1.0.3' );
	wp_enqueue_style( 'page-join', get_stylesheet_directory_uri() . '/lib/css/page-join.css', array(), '1.0.3' );
	wp_enqueue_style( 'calendar', get_stylesheet_directory_uri() . '/lib/css/calendar.css', array(), '1.0.3' );
  }
add_action( 'wp_enqueue_scripts', 'my_child_styles' );


//JS追加
function load_js() {
//管理画面を除外
if ( !is_admin() ){
//事前に読み込まれるjQueryを解除
 wp_deregister_script( 'jquery' );
//Google CDNのjQueryを出力
 wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(), NULL, true );
}
}
add_action( 'init', 'load_js' );

//作成したJSファイルの読み込み
function my_child_scripts() {
wp_enqueue_script( 'menu', get_stylesheet_directory_uri() . '/lib/js/menu.js', array( 'jquery' ), '1.0.2', true );
wp_enqueue_script( 'fade-in', get_stylesheet_directory_uri() . '/lib/js/fade-in.js', array( 'jquery' ), '1.0.2', true );
wp_enqueue_script( 'loaders.css', get_stylesheet_directory_uri() . '/lib/js/loaders.css.js', array( 'jquery' ), '1.0.2', true );
wp_enqueue_script( 'check', get_stylesheet_directory_uri() . '/lib/js/check.js', array( 'jquery' ), '1.0.2', true );
wp_enqueue_script( 'slider', get_stylesheet_directory_uri() . '/lib/js/slider.js', array( 'jquery' ), '1.0.2', true );
wp_enqueue_script( 'bg-color', get_stylesheet_directory_uri() . '/lib/js/bg-color.js', array( 'jquery' ), '1.0.2', true );
wp_enqueue_script( 'jquery.bxslider', get_stylesheet_directory_uri() . '/lib/js/jquery.bxslider.js', array( 'jquery' ), '1.0.2', true );
}
add_action( 'wp_enqueue_scripts', 'my_child_scripts' );


/*------------------------------------------------------------------------------------
/* 不要な機能の削除
/*----------------------------------------------------------------------------------*/

// headに出力されるタグを消去
remove_action( 'wp_head', 'wp_generator' ); //WordPressのバージョン情報
remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); //絵文字対応のスクリプト
remove_action( 'wp_print_styles', 'print_emoji_styles'); //絵文字対応のスタイル

// 絵文字の DNS プリフェッチだけを削除
add_filter( 'emoji_svg_url', '__return_false' );

// recent commentsのstyleを消去
function remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ));
}
add_action( 'widgets_init', 'remove_recent_comments_style' );

// カテゴリーやタグの概要<p>タグを消去
remove_filter( 'term_description','wpautop' );

// メディア画像のみタグ自動挿入の停止
function remove_p_on_images($content){
  return preg_replace('/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '\2', $content);
}
add_filter( 'the_content', 'remove_p_on_images' );

// 投稿ページ以外ではhentryクラスを削除
function remove_hentry( $classes ) {
  if ( !is_single() ) {
   $classes = array_diff( $classes, array( 'hentry' ) );
  }
  return $classes;
}
add_filter( 'post_class','remove_hentry' );

// セルフピンバックの禁止
function no_self_ping( &$links ) {
  $home = home_url();
  foreach ( $links as $l => $link )
  if ( 0 === strpos( $link, $home ) )
  unset($links[$l]);
}
add_action( 'pre_ping', 'no_self_ping' );

// the_archive_title 余計な文字を削除
function ill_archive_title( $title ) {
  if ( is_category() ) {
    $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
    $title = single_tag_title( '', false );
  }
  return $title;
}
add_filter( 'get_the_archive_title', 'ill_archive_title' );


/*------------------------------------------------------------------------------------
/* 詳細設定
/*----------------------------------------------------------------------------------*/

// テキストウィジェットでショートコード使用
add_filter('widget_text', 'do_shortcode');

// カテゴリーの投稿数表示スタイル
function ill_list_categories( $output ) {
  $output = preg_replace( '/<\/a>\s*\((\d+)\)/',' <span class="small">($1)</span></a>', $output );
  return $output;
}
add_filter( 'wp_list_categories', 'ill_list_categories', 10, 2 );

// アーカイブの投稿数表示スタイル
function  ill_list_archives( $output, $args ) {
  $output = preg_replace( '/<\/a>\s*(&nbsp;)\((\d+)\)/',' <span class="small">($2)</span></a>', $output );
  return $output;
}
add_filter( 'get_archives_link', 'ill_list_archives', 10, 2 );

// is_mobile追加
function is_mobile() {
  $useragents = array(
  'iPhone', // iPhone
  'iPod', // iPod touch
  'Android.*Mobile', // 1.5+ Android *** Only mobile
  'Windows.*Phone', // *** Windows Phone
  'dream', // Pre 1.5 Android
  'CUPCAKE', // 1.5+ Android
  'blackberry9500', // Storm
  'blackberry9530', // Storm
  'blackberry9520', // Storm v2
  'blackberry9550', // Storm v2
  'blackberry9800', // Torch
  'webOS', // Palm Pre Experimental
  'incognito', // Other iPhone browser
  'webmate' // Other iPhone browser
  );
  $pattern = '/'.implode('|', $useragents).'/i';
return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}


/*------------------------------------------------------------------------------------
/* 記事のリダイレクト
/*----------------------------------------------------------------------------------*/
// カスタムボックスの追加
add_action('admin_menu', 'add_redirect_custom_box');
if ( !function_exists( 'add_redirect_custom_box' ) ):
function add_redirect_custom_box(){

  //カスタム投稿タイプにもリダイレクト設定を追加する場合は、下記を追記
  add_meta_box( 'singular_redirect_settings', 'リダイレクト', 'redirect_custom_box_view', 'post', 'side' );
  add_meta_box( 'singular_redirect_settings', 'リダイレクト', 'redirect_custom_box_view', 'page', 'side' );
}
endif;

// リダイレクト設定の追加
if ( !function_exists( 'redirect_custom_box_view' ) ):
function redirect_custom_box_view(){
  $redirect_url = get_post_meta(get_the_ID(),'redirect_url', true);

  echo '<label for="redirect_url">リダイレクトURL</label>';
  echo '<input type="text" name="redirect_url" size="20" value="'.esc_attr(stripslashes_deep(strip_tags($redirect_url))).'" placeholder="https://" style="width: 100%;">';
  echo '<p class="howto">このページに訪れるユーザーを設定したURLに301リダイレクトします。</p>';
}
endif;

add_action('save_post', 'redirect_custom_box_save_data');
if ( !function_exists( 'redirect_custom_box_save_data' ) ):
function redirect_custom_box_save_data(){
  $id = get_the_ID();
  //リダイレクトURL
  if ( isset( $_POST['redirect_url'] ) ){
    $redirect_url = $_POST['redirect_url'];
    $redirect_url_key = 'redirect_url';
    add_post_meta($id, $redirect_url_key, $redirect_url, true);
    update_post_meta($id, $redirect_url_key, $redirect_url);
  }
}
endif;

//リダイレクトURLの取得
if ( !function_exists( 'get_singular_redirect_url' ) ):
function get_singular_redirect_url(){
  return trim(get_post_meta(get_the_ID(), 'redirect_url', true));
}
endif;

//リダイレクト処理
if ( !function_exists( 'redirect_to_url' ) ):
function redirect_to_url($url){
  header( "HTTP/1.1 301 Moved Permanently" );
  header( "location: " . $url  );
  exit;
}
endif;

//URLの正規表現
define('URL_REG_STR', '(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)');
define('URL_REG', '/'.URL_REG_STR.'/');

//リダイレクト
add_action( 'wp','wp_singular_page_redirect', 0 );
if ( !function_exists( 'wp_singular_page_redirect' ) ):
function wp_singular_page_redirect() {
  //リダイレクト
  if (is_singular() && $redirect_url = get_singular_redirect_url()) {
    //URL形式にマッチする場合
    if (preg_match(URL_REG, $redirect_url)) {
      redirect_to_url($redirect_url);
    }
  }
}
endif;


/*------------------------------------------------------------------------------------
/* カスタム投稿タイプの追加
/*----------------------------------------------------------------------------------*/

//カスタム投稿タイプ追加用のwpのアクションフック"init"*/
add_action( 'init', 'custum_post_type' );
/*ファンクション名custum_post_type""*/
function custum_post_type() {

//カスタム投稿（お知らせ）
  register_post_type( 'news',     // カスタム投稿名(半角英字)
    array('labels' =>
        array(
        'name' => __( 'お知らせ' ), //管理画面に表示される文字（日本語OK)
          'singular_name' => __( 'news' )
                     ),
        //投稿タイプの設定
               'public' => true, //公開するかしないか(デフォルト"true")
               'has_archive' => true, //trueにすると投稿した記事のアーカイブページを生成
            'menu_position' => 5,  // 管理画面上でどこに配置するか
               //投稿編集ページの設定
               'supports' => array('title','editor','thumbnail'), //タイトル，編集，アイキャッチ対応)
  )
 );
}



//__________________________________________________________________________________
//ページネーション
//__________________________________________________________________________________

function the_pagination() {
  global $wp_query;
  $bignum = 999999999;
  if ( $wp_query->max_num_pages <= 1 )
    return;
  echo '<nav class="pagination">';
  echo paginate_links( array(
    'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
    'format'       => '',
    'current'      => max( 1, get_query_var('paged') ),
    'total'        => $wp_query->max_num_pages,
    'prev_text'    => '&larr;',
    'next_text'    => '&rarr;',
    'type'         => 'list',
    'end_size'     => 3,
    'mid_size'     => 3
  ) );
  echo '</nav>';
}


//メニューの「説明」を表示
function prefix_nav_description( $item_output, $item, $depth, $args ) {
 if ( !empty( $item->description ) ) {
 $item_output = str_replace( '">' . $args->link_before . $item->title, '">' . $args->link_before . '<p>' . $item->title . '</p>' . '<span class="menu-item-description">' . $item->description . '</span>' , $item_output );
 }
 return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'prefix_nav_description', 10, 4 );

/*------------------------------------------------------------------------------------
/* ログイン画面のカスタマイズ
/*----------------------------------------------------------------------------------*/

//背景の変更
function custom_login() { ?>
<style>
  .login {
    margin: 0;
    width: 100%;
    height: 100vh;
    font-family: "Exo", sans-serif;
    color: black;
    background: linear-gradient(-45deg, #15a38c, #009E86, #30c4d1, #20ced4);
    background-size: 400% 400%;
    animation: gradientBG 10s ease infinite;
  }

  @keyframes gradientBG {
    0% {
      background-position: 0% 50%;
    }

    50% {
      background-position: 100% 50%;
    }

    100% {
      background-position: 0% 50%;
    }
  }

</style>

<?php
$files = '<link rel="stylesheet" href=" ' . get_bloginfo( 'template_directory' ) . '/lib/css/login.css" />
<script src="' . get_bloginfo( 'template_directory' ) . '/lib/js/jquery.js"></script>
<script src="' . get_bloginfo( 'template_directory' ) . '/lib/js/login.js"></script>';
echo $files;
}
add_action( 'login_enqueue_scripts', 'custom_login' );

//ロゴを変更
function custom_login_logo() { ?>
<style>
  .login #login h1 a {
    background: url(/wp-content/uploads/Ill-white.png) no-repeat center center;
    background-size: contain;
    width: 300px;
    height: 80px;
  }

  .login #backtoblog a,
  .login #nav a {
    text-decoration: none;
    color: white !important;
  }

  .wp-core-ui .button-primary {
    background: #ffa73b !important;
    border-color: #ffa73b !important;
    box-shadow: 0 1px 0#ffa73b !important;
    text-shadow: initial !important;
  }

</style>
<?php }
add_action( 'login_enqueue_scripts', 'custom_login_logo' );

//ロゴのリンク先を変更
function custom_login_logo_url() {
  return 'https://i-will.design/';
}
add_filter( 'login_headerurl', 'custom_login_logo_url' );


function send_mail_smtp($phpmailer)
{
    $phpmailer->isSMTP();                     //SMTP有効設定
    $phpmailer->Host = "sv8088.xserver.jp";  //メールサーバーのホスト名
    $phpmailer->SMTPAuth = true;              //SMTP認証の有無（true OR false）
    $phpmailer->Port = "587";                 //SMTPポート番号(ssl:465 tls:587)
    $phpmailer->Username = "test@clane01.xsrv.jp";        //ユーザー名
    $phpmailer->Password = "rhythm0802";   //パスワード
    $phpmailer->SMTPSecure = "tls";           //SMTP暗号化方式（ssl OR tls）
    $phpmailer->From = "test@clane01.xsrv.jp";    //送信者メールアドレス
//  $phpmailer->SMTPDebug = 2;                //デバッグ表示
}
add_action("phpmailer_init", "send_mail_smtp");