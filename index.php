<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

get_header();
?>
<div id="l-container">
	<div id="l-main-contents">

		<?php get_template_part( 'parts/mv' ); // MV. ?>
		<?php get_template_part( 'parts/profile' ); // profile. ?>
		<?php get_template_part( 'parts/works' ); // works. ?>

	</div>
</div>
<?php wp_body_open(); ?>
<?php get_footer(); ?>
