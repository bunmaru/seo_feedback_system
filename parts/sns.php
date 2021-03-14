<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

$share_url_base   = get_permalink();
$share_title_base = get_the_title() . ' | ' . get_bloginfo( 'name' );

$share_url_tw = 'https://twitter.com/intent/tweet?text=' . rawurlencode( $share_title_base ) . '&amp;url=' . rawurlencode( $share_url_base );
$share_url_fb = '//www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $share_url_base );
$share_url_li = '//timeline.line.me/social-plugin/share?url=' . rawurlencode( $share_url_base );

?>


<div class="l-contents l-contents-short">
	<div class="p-share">
		<ul class="p-share-list-area">
			<!-- ツイッター -->
			<li class="p-share-item"><a class="p-share-link p-share-link-tw" href="<?php echo esc_url( $share_url_tw ); ?>"  target="_blank" rel="nofollow noopener noreferrer"><i class="fab fa-twitter"></i></a></li>

			<!-- facebook -->
			<li class="p-share-item"><a class="p-share-link p-share-link-fa" href="<?php echo esc_url( $share_url_fb ); ?>" target="_blank" rel="nofollow noopener noreferrer"
		onclick="window.open(this.href, 'SNS', 'width=500, height=500, menubar=no, toolbar=no, scrollbars=yes'); return false;"><i class="fab fa-facebook"></i></a></li>

			<!-- LINE -->
			<li class="p-share-item">
			<a class="p-share-link p-share-link-li" href="<?php echo esc_url( $share_url_li ); ?>" target="_blank" rel="nofollow noopener noreferrer" title="LINEに送る">
				<i class="fab fa-line"></i>
			</a>
			</li>
		</ul>
	</div>
</div>


