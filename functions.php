<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */
require_once get_template_directory() . '/lib/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

function generate_pdf($ID, $post) {
    // 投稿ページのURLを取得
    $url = get_permalink($ID);
    $html = file_get_contents($url);  // 投稿ページのHTMLを取得

    // DOMPDFの設定
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $options->set('isRemoteEnabled', true);  // リモートコンテンツの使用を許可
    $dompdf = new Dompdf($options);

    // テーマのstyle.cssを読み込む
    $theme_directory = get_template_directory();
    $css_file = $theme_directory . '/style.css';

    // CSSで倍率と余白を調整
    $custom_css = '
        @font-face {
            font-family: "Noto Sans JP";
            src: url("/lib/dompdf/vendor/dompdf/dompdf/lib/fonts/NotoSansJP-VariableFont_wght.ttf");
        }
        body {
            font-family: "Noto Sans JP", sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            overflow: hidden;
            transform: scale(0.5); /* サイズ調整（86％に設定） */
            transform-origin: top left;
        }
        @page {
            margin: 0; /* 余白なし */
            size: A4; /* 用紙サイズをA4に設定 */
        }
        .container {
            width: 100%;
            height: 100%;
            box-sizing: border-box;
        }
    ';
    
    // CSSをHTMLに追加
	$html = '<meta charset="UTF-8">' . '<style>' . $custom_css . '</style>' . $html;

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');  // A4縦の設定
    $dompdf->render();

    // PDFの保存
    $upload_dir = wp_upload_dir();
    $pdf_dir = $upload_dir['basedir'] . '/pdf';  // pdfフォルダ内に保存
    if (!file_exists($pdf_dir)) {
        wp_mkdir_p($pdf_dir);  // フォルダが存在しない場合は作成
    }
    $pdf_output_path = $pdf_dir . "/post-$ID.pdf";
    file_put_contents($pdf_output_path, $dompdf->output());
}

// 新規投稿時にPDFを生成
add_action('publish_post', 'generate_pdf', 10, 2);

// 投稿が更新された場合にもPDFを生成
add_action('post_updated', 'generate_pdf', 10, 2);




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
// get_template_part( 'inc/customizer' ); // カスタマイザーの設定.
// get_template_part( 'inc/widgets' ); // ウィジェットの設定.
// get_template_part( 'inc/shortcode' ); // ショートコードの設定.
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
