<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

get_header(); ?>

<div id="l-container">
	<div id="l-main-contents">

		<?php get_template_part( 'parts/mv' ); // MV. ?>
		<?php get_template_part( 'parts/profile' ); // profile. ?>

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
			<section class="u-bg-yellow">
				<article <?php post_class( 'p-article l-contents' ); ?>>
					<?php the_content(); ?>
				</article>
			</section>
				<?php
			endwhile;
		endif;
		?>

	</div>
</div>

<?php get_footer(); ?>
