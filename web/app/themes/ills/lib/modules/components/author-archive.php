<?php
/**
* Author profile archive
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
*/
 $user_display_name = get_the_author_meta( 'display_name' );
 $user_position = get_the_author_meta( 'user_position' );
 $user_url = get_the_author_meta( 'user_url' );
 $user_description = get_the_author_meta( 'user_description') ;
 $user_twitter = get_the_author_meta( 'user_twitter' );
 $user_facebook = get_the_author_meta( 'user_facebook') ;
 $user_instagram = get_the_author_meta( 'user_instagram' );
 $user_line = get_the_author_meta( 'user_line' );
 $user_youtube = get_the_author_meta( 'user_youtube' );
?>
<!--author profile-->
<div class="author-archive">
	<div class="author-profile-content">
		<div class="avatar">
		 <?php echo get_avatar( get_the_author_meta( 'ID' ), 96, '', $user_display_name ); ?>
		</div>
		<div class="author-profile-text">
			<?php if( $user_position ){ ?>
			<span><?php echo esc_html( $user_position ); ?></span>
			<?php } ?>
			<?php if( $user_description ){ ?>
			<p><?php echo esc_html( $user_description ); ?></p>
			<?php } ?>
			<div class="author-sns">
				<?php if( $user_url || $user_twitter || $user_facebook || $user_instagram || $user_line || $user_youtube ){ ?>
				<ul>
					<?php } ?>
					<?php if( $user_url ){ ?>
					<li class="follow-user-url"><a href="<?php echo $user_url ?>" target="_blank"><i class="fa fa-user-circle"></i></a></li>
					<?php } ?>
					<?php if( $user_twitter ){ ?>
					<li class="follow-twitter"><a href="<?php echo $user_twitter ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
					<?php } ?>
					<?php if( $user_facebook ){ ?>
					<li class="follow-facebook"><a href="<?php echo $user_facebook ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
					<?php } ?>
					<?php if( $user_instagram ){ ?>
					<li class="follow-instagram"><a href="<?php echo $user_instagram ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
					<?php } ?>
					<?php if( $user_line ){ ?>
					<li class="follow-line"><a href="<?php echo $user_line ?>" target="_blank">LINE@</a></li>
					<?php } ?>
					<?php if( $user_youtube ){ ?>
					<li class="follow-youtube"><a href="<?php echo $user_youtube ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
					<?php } ?>
					<?php if( $user_url || $user_twitter || $user_facebook || $user_instagram || $user_line || $user_youtube ){ ?>
				</ul>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<!--end author profile-->