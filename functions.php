<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

/**
 * 各種設定を行う
 */
function col_theme_setup() {
	// ページタイトルの設定.
	add_theme_support( 'title-tag' );
	// html5に対応.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	// カスタムエディターのCSSに対応する.
	add_editor_style( 'editor-style.css' );
	// アイキャッチ画像を設定する.
	add_theme_support( 'post-thumbnails' );
	// ナビゲーションメニューを有効にする.
	register_nav_menus(
		array(
			'primary' => 'メイン',
		)
	);
}
add_action( 'after_setup_theme', 'col_theme_setup' );


// 画像アップロード時の、自動縮小を止める.
add_filter( 'wp_big_image_size_threshold', '__return_false' );

/**
 * 関数を個々に読み込む
 */
//get_template_part( 'inc/customizer' ); // カスタマイザーの設定.
// get_template_part( 'inc/widgets' ); // ウィジェットの設定.
//get_template_part( 'inc/shortcode' ); // ショートコードの設定.
// get_template_part( 'inc/search' ); // 検索ページの機能.

/**
 * Imgタグに自動付与されるpタグをfigureタグに変更する
 *
 * @param object $content パラメーター.
 */
function col_replace_p_on_img( $content ) {
	return preg_replace( '/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '<figure>$2</figure>', $content );
}
add_filter( 'the_content', 'col_replace_p_on_img' );

/**
 * 空白,NULLをチェックする
 * null is true, "" is true, 0 and "0" is false, " " is false.
 *
 * @param object $obj パラメーター.
 */
function col_is_nullorempty( $obj ) {
	if ( 0 === $obj || '0' === $obj ) {
		return false;
	}
	return empty( $obj );
}

/**
 * アイキャッチ画像を取得する
 *
 * @param string $size パラメーター.
 */
function col_echo_thumb( $size ) {
	$url = '';
	if ( has_post_thumbnail() ) {
		$url = get_the_post_thumbnail_url( '', $size );
	} else {
		$url = get_template_directory_uri() . '/images/600x400.png';
	}
	return $url;
}

/**
 * ページャー(記事)にクラスを付与する
 *
 * @param string $output パラメーター.
 */
function col_add_prev_post_link_class( $output ) {
	return str_replace( '<a href=', '<a class="p-pagination2-link p-pagination2-link-prev" href=', $output );
}
add_filter( 'previous_post_link', 'col_add_prev_post_link_class' );

/**
 * ページャー(記事)にクラスを付与する
 *
 * @param string $output パラメーター.
 */
function col_add_next_post_link_class( $output ) {
	return str_replace( '<a href=', '<a class="p-pagination2-link p-pagination2-link-next" href=', $output );
}
add_filter( 'next_post_link', 'col_add_next_post_link_class' );

/**
 * 外部スタイルやjsをを読見込む
 */
function col_load_css_js() {
	$version = wp_get_theme()->get( 'Version' );
	// style.css.
	wp_enqueue_style( 'style', get_stylesheet_uri(), array(), $version );
	// google_fonts.
	wp_enqueue_style( 'google_fonts', 'https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&family=Noto+Sans:wght@400;700&display=swap', array(), $version );
	// fontawesome.
	wp_enqueue_script( 'fontawesome', 'https://kit.fontawesome.com/421ad94433.js', array(), $version, false );
	// google_fonts.
	wp_enqueue_script( 'chart', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js', array(), $version, false );
}
add_action( 'wp_enqueue_scripts', 'col_load_css_js' );

/**
 * 　ページネーションを出力する
 *
 * @param int $max_num_pages 該当のクエリのトータルページ数.
 * @param int $now_paged 現在のページ数.
 */
function col_the_pagenation( $max_num_pages = 0, $now_paged = '1' ) {
	// 表示テキスト.
	$text_first  = '«';
	$text_before = '‹';
	$text_next   = '›';
	$text_last   = '»';
	$range       = 2;

	if ( $max_num_pages < 2 ) {
		return;
	}

	$result = '';

	// 現在のページ番号が全ページ数よりも少ないときは「次のページ」タグを出力.
	if ( $now_paged < $max_num_pages ) {
		$url    = get_pagenum_link( $now_paged + 1 );
		$result = '<a href="' . esc_url( $url ) . '" class="c-btn u-mt-on-btn"><span class="c-arrow">次のページ</span></a>';
	}

	$result .= '<div class="p-pagination">';

	if ( $now_paged > 1 ) {
		// 「前へ」 の表示
		$result .= '<a href="' . get_pagenum_link( 1 ) . '" class="p-pagination__first p-pagination__pager">' . $text_first . '</a>';
		$result .= '<a href="' . get_pagenum_link( $now_paged - 1 ) . '" class="p-pagination__prev p-pagination__pager">' . $text_before . '</a>';
	}
	for ( $i = 1; $i <= $max_num_pages; $i++ ) {

		if ( $i <= $now_paged + $range && $i >= $now_paged - $range ) {
			// $paged +- $range 以内であればページ番号を出力
			if ( $now_paged === $i ) {
				$result .= '<span class="p-pagination__current p-pagination__pager">' . $i . '</span>';
			} else {
				$result .= '<a href="' . get_pagenum_link( $i ) . '" class="p-pagination__pager">' . $i . '</a>';
			}
		}
	}
	if ( $now_paged < $max_num_pages ) {
		// 「次へ」 の表示
		$result .= '<a href="' . get_pagenum_link( $now_paged + 1 ) . '" class="p-pagination__next p-pagination__pager">' . $text_next . '</a>';
		$result .= '<a href="' . get_pagenum_link( $max_num_pages ) . '" class="p-pagination__last p-pagination__pager">' . $text_last . '</a>';
	}

	$result .= '</div>';
	echo wp_kses( $result, wp_kses_allowed_html( 'post' ) );
}