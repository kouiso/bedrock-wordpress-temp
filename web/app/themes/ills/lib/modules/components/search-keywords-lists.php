<?php
/**
* Search keywords lists
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
*/

	$search_keywords_label = get_theme_mod( 'search_keywords_label', __( 'Remarks', 'ill' ) );
	$search_keywords = array(
		'search_keywords_1' => get_theme_mod( 'search_keywords_1', '' ),
		'search_keywords_2' => get_theme_mod( 'search_keywords_2', '' ),
		'search_keywords_3' => get_theme_mod( 'search_keywords_3', '' ),
		'search_keywords_4' => get_theme_mod( 'search_keywords_4', '' ),
		'search_keywords_5' => get_theme_mod( 'search_keywords_5', '' ),
		'search_keywords_6' => get_theme_mod( 'search_keywords_6', '' ),
		'search_keywords_7' => get_theme_mod( 'search_keywords_7', '' ),
		'search_keywords_8' => get_theme_mod( 'search_keywords_8', '' ),
		'search_keywords_9' => get_theme_mod( 'search_keywords_9', '' ),
		'search_keywords_10' => get_theme_mod( 'search_keywords_10', '' ),
	);
?>


<div class="search-keywords-lists">
	<div class="container">
		<nav class="mb-scroll-arrow-sk">
		<ul>
		<?php if ( $search_keywords_label ): ?>
		<li class="search-keywords-label"><?php echo $search_keywords_label; ?></li>
		<?php endif; ?>
		<?php $c = 1; ?>
		<?php foreach ( $search_keywords as $keyword ):?>
		<?php if ( $keyword ): ?>
		<li><a href="<?php echo home_url(); ?>?s=<?php echo esc_html( $keyword ) ?>"><?php echo esc_html( $keyword ); ?></a></li>
		<?php $c++; ?>
		<?php endif; ?>
		<?php endforeach; ?>
		</ul>
		</nav>
	</div>
</div>
