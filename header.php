<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head prefix="og: http://ogp.me/ns#">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header id="l-header" class="p-header">
	<div id="js-sp-nav" class="l-header-inner p-header-inner">

		<div class="p-header-logo-area">

			<?php ( is_front_page() || is_home() ) ? $title_tag = 'h1' : $title_tag = 'div'; ?>
			<<?php echo esc_html( $title_tag ); ?> class="p-header-logo-title">
				<a class="p-header-logo-link" href="<?php echo esc_url( home_url() ); ?>">
					<?php bloginfo( 'name' ); ?>
				</a>
			</<?php echo esc_html( $title_tag ); ?>>
		</div>

		<!-- メニュー -->
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<p id="js-menu-btn" class="p-menu-btn u-pc-hdn">
				<span></span><span></span><span></span>
			</p>
			<div class="p-sitenav u-sp-hdn">
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'container'       => 'nav',
					'container_class' => 'p-mainmenu',
				)
			);
			?>
			</div>
			<div class="p-sitenav-sp u-pc-hdn">
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'container'       => 'nav',
					'container_class' => 'p-mainmenu-sp',
				)
			);
			?>
			</div>
		<?php endif; ?>

	</div>
</header>
