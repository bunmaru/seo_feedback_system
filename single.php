<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

?>

<?php get_header(); ?>

<div id="l-container">
	<div id="l-main-contents">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>

		<!-- タイトルエリア -->	
		<section class="u-bg-yellow">
			<div class="l-contents p-eyecatch">
				<div class="l-contents-narrow">
					<h1 class="p-eyecatch-title p-section-ttl"> <?php the_title(); ?></h1>
					<p class="p-eyecatch-date date u-text-aside">
						<i class="fas fa-calendar-week u-mr-icon "></i>
						<span><?php echo get_the_date( 'Y' ); ?></span>
					</p>
					<div class="p-eyecatch-cat-area">
						<?php get_template_part( 'parts/categorylist' ); ?>
					</div>
					<?php if ( ! empty( $post->post_password ) ) : // パスワード設定されている場合はラベル表示. ?>
						<div class="p-eyecatch-lock">
						<?php get_template_part( 'parts/password' ); ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- アイキャッチ画像 -->	
				<?php if ( ! post_password_required( $post->ID ) ) : // ロックされてなければ表示. ?>
					<?php if ( has_post_thumbnail() ) : // アイキャッチ画像あれば表示. ?>
						<figure class="p-eyecatch-img-area"><img class="p-eyecatch-img p-floting-img" src="<?php echo esc_url( col_echo_thumb( 'thumb-996' ) ); ?>" alt=""></figure>
					<?php endif; ?>
				<?php endif; ?>

			</div>
		</section>

		<section class="l-contents">
			<article <?php post_class( 'p-article' ); ?>>
				<?php the_content(); ?>
			</article>
		</section>

			<?php get_template_part( 'parts/sns' ); ?>

		<!-- ページャー -->	
		<div class="l-contents-short l-contents-narrow u-border-top-dashed">
			<div class="p-pagination2">
				<?php previous_post_link( '%link', '<i class="fas fa-arrow-left"></i><div class="p-pagination2-text c-label-spin" data-text="Prev"><span class="c-label-spin-text">Prev</span></div>', true ); ?>
				<a class="p-pagination2-link p-pagination2-link-home" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<i class="fas fa-home"></i>
				</a>
				<?php next_post_link( '%link', '<div class="p-pagination2-text c-label-spin" data-text="Next"><span class="c-label-spin-text">Next</span></div><i class="fas fa-arrow-right"></i>', true ); ?>
			</div>
		</div>

			<?php
			// Other Works.
			$categories    = get_the_category();
			$categories_id = array();
			foreach ( $categories as $category ) {
				$categories_id[] = $category->term_id;
			}
			$args      = array(
				'post-not_in'    => array( $post->ID ),
				'category-in'    => $categories_id,
				'posts_per_page' => 3,
				'orderby'        => 'rand',
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) :
				?>
			<section class="u-bg-yellow">
				<div class="l-contents">
					<h2 class='p-section-ttl'>Other Works</h2>
						<div class='l-content-m l-row'>
								<?php
								while ( $the_query->have_posts() ) :
									$the_query->the_post();
									?>
									<?php get_template_part( 'parts/contentsbox', 'pc3-sm1' ); ?>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</section>
				<?php
			endif;
			wp_reset_postdata();
			?>

			<?php
		endwhile;
		endif;
	?>
	</div>
</div>
<?php get_footer(); ?>
