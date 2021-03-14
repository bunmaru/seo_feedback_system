<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

?>

<div class="p-mv">
	<?php if ( ! empty( col_get_headerimg_url() ) ) : ?>
		<div class="p-mv-inner" style="background-image: url('<?php echo esc_url( col_get_headerimg_url() ); ?>')"></div>
	<?php else : ?>
		<div class="p-mv-inner p-mv-inner-noimg" ></div>
	<?php endif ?>
</div>
