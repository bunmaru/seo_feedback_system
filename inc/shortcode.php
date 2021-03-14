<?php
/**
 * Collection WordPress Theme
 *
 * @package Perakoya
 */

/**
 * ショートコード
 * SKILL用のプログレッシブバー(エリア)を出力する
 *
 * @param object $atts パラメーター.
 * @param object $content パラメーター.
 */
function col_shortcode_progress_bar_area( $atts, $content = null ) {
	// pタグの除去.
	$outoput = do_shortcode( shortcode_unautop( $content ) );

	if ( ! col_is_nullorempty( $outoput ) ) {
		return '<div class="p-progress">' . $outoput . '</div>';
	}
}
add_shortcode( 'skills', 'col_shortcode_progress_bar_area' );

/**
 * ショートコード
 * SKILL用のプログレッシブバー(アイテム)を出力する
 *
 * @param object $atts パラメーター.
 * @param object $content パラメーター.
 */
function col_shortcode_progress_bar( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'name'  => 'skill name',
			'score' => 0,
			'years' => '-',
		),
		$atts
	);

	// チェックとエスケープと変数化.
	$name  = esc_html( $atts['name'] );
	$score = esc_html( intval( $atts['score'] ) );
	if ( $score > 10 ) {
		$score = 10;
	}
	$score_percentage = esc_attr( $score * 10 );
	$years            = esc_html( $atts['years'] );

	// HTML作成.
	$outoput = <<<EOD

	<div class="p-progress-inner">
		<p class="p-progress-title">${name}</p>		
		<div class="p-progress-bar-area">
			<div class="p-progress-bar" style="width:${score_percentage}%;"></div>
		</div>
		<div class="p-progress-meta">
			<span class="p-progress-years u-text-aside">経験年数${years}年</span>
			<span class="p-progress-score u-text-aside">習得度${score}</span>
		</div>
	</div>

EOD;

	return $outoput;
}
add_shortcode( 'skill', 'col_shortcode_progress_bar' );

/**
 * ショートコード
 * SKILL用のLink & Contact(エリア)を出力する
 *
 * @param object $atts パラメーター.
 * @param object $content パラメーター.
 */
function col_shortcode_linkarea( $atts, $content = null ) {
	// pタグの除去.
	$outoput = do_shortcode( shortcode_unautop( $content ) );
	if ( ! col_is_nullorempty( $outoput ) ) {
		return '<div class="p-links"><dl>' . $outoput . '</dl></div>';
	}
}
add_shortcode( 'links', 'col_shortcode_linkarea' );

/**
 * ショートコード
 * SKILL用のLink & Contact(中身)を出力する
 *
 * @param object $atts パラメーター.
 * @param object $content パラメーター.
 */
function col_shortcode_link( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'name' => 'リンク先名',
			'url'  => '#',
		),
		$atts
	);

	// チェックとエスケープと変数化.
	$name     = esc_html( $atts['name'] );
	$url_link = esc_url( ( $atts['url'] ) );
	$url_text = esc_html( ( $atts['url'] ) );

	// HTML作成.
	$outoput = <<<EOD

	<div class="p-links-set">
		<dt class="p-links-way">${name}</dt>
		<dd class="p-links-link"><a href="${url_link}" target="_blank">${url_text}</a></dd>
	</div>

EOD;

	return $outoput;
}
add_shortcode( 'link', 'col_shortcode_link' );

/**
 * ショートコード
 * SKILL用のタイムライン(エリア)を出力する
 *
 * @param object $atts パラメーター.
 * @param object $content パラメーター.
 */
function col_shortcode_tmelinearea( $atts, $content = null ) {
	// pタグの除去.
	$outoput = do_shortcode( shortcode_unautop( $content ) );
	if ( ! col_is_nullorempty( $outoput ) ) {
		return '<div class="p-timeline"><ul class="p-timeline-list">' . $outoput . '</ul></div>';
	}
}
add_shortcode( 'timelines', 'col_shortcode_tmelinearea' );

/**
 * ショートコード
 * SKILL用のタイムライン(中身)を出力する
 *
 * @param object $atts パラメーター.
 * @param object $content パラメーター.
 */
function col_shortcode_timeline( $atts, $content = null ) {

	// チェックと変数化.
	$years = null;
	if ( ( ! col_is_nullorempty( $atts['start'] ) ) || ( ! col_is_nullorempty( $atts['end'] ) ) ) {
		$years = '<div class="p-timeline-year u-text-aside"><span class="p-timeline-start">' . esc_html( $atts['start'] ) . '</span><span class="p-timeline-end">-' . esc_html( $atts['end'] ) . '</span></div>';
	}
	$title = ! col_is_nullorempty( $atts['title'] ) ? '<div class="p-timeline-title">' . esc_html( $atts['title'] ) . '</div>' : null;
	$desc  = ! col_is_nullorempty( $content ) ? '<div class="p-timeline-desc">' . esc_html( $content ) . '</div>' : null;

	// 全てからなら空白を返す.
	if ( col_is_nullorempty( $years ) && col_is_nullorempty( $title ) && col_is_nullorempty( $desc ) ) {
		return '';
	}

	// HTML作成.
	$outoput = <<<EOD

	<li class="p-timeline-item u-br-normal">
		${years}
		${title}
		${desc}
	</li> 

EOD;

	return $outoput;

}
add_shortcode( 'timeline', 'col_shortcode_timeline' );

/**
 * ショートコード
 * 記事用のリスト(エリア)を出力する
 *
 * @param object $atts パラメーター.
 * @param object $content パラメーター.
 */
function col_insert_list( $atts, $content = null ) {
	// pタグの除去.
	$outoput = do_shortcode( shortcode_unautop( $content ) );
	if ( ! col_is_nullorempty( $content ) ) {
		return '<div class="p-desc u-text-aside">' . $outoput . '</div>';
	}
}
add_shortcode( 'desc', 'col_insert_list' );

/**
 * ショートコード
 * スクロール画像をを出力する
 *
 * @param object $atts パラメーター.
 * @param object $content パラメーター.
 */
function col_shortcode_scroll_img( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'size' => 'pc',
		),
		$atts
	);

	// チェックとエスケープと変数化.
	$size = esc_attr( $atts['size'] );
	$img  = ! col_is_nullorempty( $content ) ? '<div class="p-scroll-img__box c-img-fixed-ratio c-img-fixed-ratio--browser">' . wp_kses_post( shortcode_unautop( $content ) ) . '</div>' : null;

	// HTML作成.
	$outoput = <<<EOD
	<div class="p-scroll-img p-scroll-img--${size}">
		<div class="p-scroll-img__inn">
		${img}
		</div>
	</div>

EOD;

	return $outoput;
}
add_shortcode( 'scroll', 'col_shortcode_scroll_img' );
