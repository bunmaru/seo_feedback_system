<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

?>
<ul class="p-card-cat-area u-text-aside">
	<li class="p-card-cat c-label c-label-light u-hover-enlarge">
	<?php
		$category_list = get_the_category_list( '</li><li class="p-card-cat c-label c-label-light u-hover-enlarge">' );
		echo wp_kses( $category_list, wp_kses_allowed_html( 'post' ) );
	?>
</ul>
