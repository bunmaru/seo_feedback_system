<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

get_header();
?>
<main class="p-index">
	<ul class='p-media-unit'>
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endwhile; ?>
		<?php else : ?>
		<div class="error">
			<p>お探しの記事は見つかりませんでした。</p>
		</div>
		<?php endif; ?>
	</ul>
	<?php
		// ページャーを出力する.
		global $wp_query;
		col_the_pagenation( $wp_query->max_num_pages, max( 1, get_query_var( 'paged' ) ) );
	?>
</main>

<?php wp_body_open(); ?>
<?php get_footer(); ?>
