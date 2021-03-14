<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

?>

<div class="l-contents l-contents-narrow l-contents-shihtup">
	<div class="p-profile">

		<?php if ( ! empty( col_get_profileimg_url() ) ) : // プロフィール画像. ?>
			<figure class="p-profile-img-area"><img class="p-profile-img u-br-50 u-border-white" src="<?php echo esc_url( col_get_profileimg_url() ); ?>" alt=""></figure>
		<?php else : ?>
			<figure class="p-profile-img-area"><img class="p-profile-img u-br-50 u-border-white" src="<?php echo esc_url( get_template_directory_uri() ) . '/images/profile.png'; ?>" alt=""></figure>
		<?php endif ?>

		<div class="p-profile-personal">
			<?php if ( ! empty( col_get_profile_name() ) ) : // 名前. ?>
				<p class="p-profile-name"><?php echo esc_html( col_get_profile_name() ); ?></p>
			<?php endif ?>

			<?php if ( ! empty( col_get_profile_city() ) ) : // 移住地. ?>
				<p class="p-profile-city u-text-aside">
					<i class="fas fa-map-marker-alt u-mr-icon "></i>
					<span class="p-profile-cityText"><?php echo esc_html( col_get_profile_city() ); ?></span>
				</p>
			<?php endif ?>
		</div>

		<?php if ( ! empty( col_get_profile_text() ) ) : // 自己紹介. ?>
			<p class="p-profile-text"><?php echo esc_html( col_get_profile_text() ); ?></p>
		<?php endif ?>

		<?php if ( is_front_page() || is_home() ) : // ボタン. ?>
			<?php if ( ! empty( col_get_profile_url() ) ) : ?>
				<a class="p-profile-btn c-btn c-btn-primary u-hover-enlarge" href="<?php echo esc_url( home_url( '/' ) . col_get_profile_url() ); ?>">プロフィールはこちら<i class="fas fa-arrow-right" aria-hidden="true"></i></a>
			<?php endif ?>
		<?php endif ?>

	</div>
</div>
