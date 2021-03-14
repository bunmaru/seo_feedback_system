<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

?>
<!-- Works -->
<section class="u-bg-yellow">
	<div class="l-contents">
		<h2 class='p-section-ttl'>Works</h2>
		<?php
		// 絞り込みリスト.
			$args       = array(
				'parent'     => 0,
				'orderby'    => 'id',
				'pad_counts' => true,
			);
			$categories = get_categories( $args );
			?>
		<div class="l-content-s">
			<ul class="p-sortnav u-fontfamily-nomal">
				<!-- All -->
				<li class="p-sortnav-item
				<?php
				if ( is_front_page() || is_home() ) {
					echo ' current';}
				?>
				">
				<?php
					$count_posts = wp_count_posts();
					$pub_posts   = $count_posts->publish;
				?>
					<a class="p-sortnav-cat-area" href="<?php echo esc_url( home_url( '' ) ); ?>"> 
						<span class="p-sortnav-cat">All</span>
						<span class="p-sortnav-count c-label c-label-round-l"><?php echo esc_html( $pub_posts ); ?></span>
					</a>
				</li>

				<?php
				// その他カテゴリー.
				foreach ( $categories as $category ) :
					?>
					<?php $category_link = get_category_link( $category->term_id ); ?>
					<li class="p-sortnav-item
					<?php
					if ( is_category( $category->cat_ID ) ) {
						echo ' current';}
					?>
					">
						<a class="p-sortnav-cat-area" href="<?php echo esc_url( $category_link ); ?>">
							<span class="p-sortnav-cat"><?php echo esc_html( $category->name ); ?></span>
							<span class="p-sortnav-count c-label c-label-round-l"><?php echo esc_html( $category->count ); ?></span>
					</a>
					</li>
				<?php endforeach; ?>

			</ul>
		</div>

		<!-- works一覧 -->
		<div class='l-content-m l-row'>
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'parts/contentsbox', 'pc3-sm1' );
				}
			}
			?>
		</div>

		<?php
		// ページャー
		// ページャーが必要かチェック.
		$prev = get_previous_posts_link();
		$next = get_next_posts_link();
		if ( ( isset( $prev ) ) || ( isset( $next ) ) ) :
			?>
			<div class="p-pagination l-content-m">
				<?php
				$paginate_list = paginate_links(
					array(
						'type'      => 'list',
						'prev_text' => '&lt;',
						'next_text' => '&gt;',
						'end_size'  => '0',
						'mid_size'  => '1',
					)
				);
					echo wp_kses( $paginate_list, wp_kses_allowed_html( 'post' ) );
				?>
			</div>
		<?php endif ?>
	</div>
</section>
