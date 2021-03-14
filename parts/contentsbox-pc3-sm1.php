<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

?>
<article <?php post_class( 'l-col2-s l-col3-lg p-card' ); ?>>
	<a class="p-card-link-box" href="<?php the_permalink(); ?>">
		<div class="p-card-inner">
			<figure class="p-card-img-area c-img-fixed-ratio">
				<?php if ( post_password_required( $post->ID ) ) : // パスワードロックされている場合破は、ロック用の画像を出力. ?>
					<img class="p-card-img" src="<?php echo esc_url( get_template_directory_uri() . '/images/lock.png' ); ?>" alt="<?php echo 'パスワードロックされています'; ?> ">
				<?php else : ?>
					<img class="p-card-img" src="<?php echo esc_url( col_echo_thumb( 'thumb-600' ) ); ?>" alt="<?php the_title(); ?> ">
				<?php endif; ?>
			</figure>
			<div class="p-card-text-area">

				<?php if ( ! col_is_nullorempty( $post->post_password ) ) : // パスワード設定されている場合はラベル表示. ?>
					<div class="p-card-lock">
						<?php get_template_part( 'parts/password' ); ?>
					</div>
				<?php endif; ?>

				<h2 class="p-card-title u-lineh-s"> <?php the_title(); ?></h2>
				<p class="p-card-date u-text-aside">
					<i class="fas fa-calendar-week u-mr-icon "></i>
					<span><?php echo get_the_date( 'Y' ); ?></span>
				</p>
			</div>
		</div>
	</a>
	<div class="p-card-footer">
		<?php get_template_part( 'parts/categorylist' ); ?>
	</div>
</article>
