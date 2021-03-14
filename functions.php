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

// アイキャッチ画像の追加.
add_image_size( 'thumb-996', 996, 560, array( 'center', 'top' ) ); // 記事ページのMV.
add_image_size( 'thumb-600', 600, 400, array( 'center', 'top' ) ); // サムネイルサイズ.

// 画像アップロード時の、自動縮小を止める.
add_filter( 'wp_big_image_size_threshold', '__return_false' );

/**
 * 関数を個々に読み込む
 */
get_template_part( 'inc/customizer' ); // カスタマイザーの設定.
// get_template_part( 'inc/widgets' ); // ウィジェットの設定.
get_template_part( 'inc/shortcode' ); // ショートコードの設定.
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
	wp_enqueue_script( 'fontawesome', 'https://kit.fontawesome.com/421ad94433.js', array(), $version, true );
	// highlight.js.
	if ( is_singular() ) {
		wp_enqueue_style( 'hljs-style', '//cdn.jsdelivr.net/gh/highlightjs/cdn-release@10.2.1/build/styles/monokai-sublime.min.css', array(), $version );
		wp_enqueue_script( 'hljs-script', '//cdn.jsdelivr.net/gh/highlightjs/cdn-release@10.2.1/build/highlight.min.js', array(), $version, true );
		wp_add_inline_script( 'hljs-script', 'hljs.initHighlightingOnLoad();' );
	}
}
add_action( 'wp_enqueue_scripts', 'col_load_css_js' );

/**
 * OGPタグ/Twitterカード設定を出力
 */
function col_outoput_ogp() {
	if ( is_front_page() || is_home() || is_singular() ) {
		global $post;
		$ogp_title = '';
		$ogp_descr = '';
		$ogp_url   = '';
		$ogp_img   = '';
		$insert    = '';

		// 記事＆固定ページ.
		if ( is_singular() ) {
			setup_postdata( $post );
			$ogp_title = $post->post_title;
			$ogp_descr = mb_substr( get_the_excerpt(), 0, 100 );
			$ogp_url   = get_permalink();
			wp_reset_postdata();
			// トップページ.
		} elseif ( is_front_page() || is_home() ) {
			$ogp_title = get_bloginfo( 'name' );
			$ogp_descr = get_bloginfo( 'description' );
			$ogp_url   = home_url();
		}

		// og:type.
		$ogp_type = ( is_front_page() || is_home() ) ? 'website' : 'article';

		// og:image.
		if ( is_singular() && has_post_thumbnail() ) {
			$ps_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			$ogp_img  = $ps_thumb[0];
		} else {
			$ogp_img = '';
		}

		$insert .= '<meta property="og:title" content="' . esc_attr( $ogp_title ) . '" />' . "\n";
		$insert .= '<meta property="og:description" content="' . esc_attr( $ogp_descr ) . '" />' . "\n";
		$insert .= '<meta property="og:type" content="' . $ogp_type . '" />' . "\n";
		$insert .= '<meta property="og:url" content="' . esc_url( $ogp_url ) . '" />' . "\n";
		$insert .= '<meta property="og:image" content="' . esc_url( $ogp_img ) . '" />' . "\n";
		$insert .= '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
		$insert .= '<meta name="twitter:card" content="summary_large_image" />' . "\n";
		$insert .= '<meta name="twitter:site" content="@kaisetsusan" />' . "\n";
		$insert .= '<meta property="og:locale" content="ja_JP" />' . "\n";

		// facebookのapp_id（設定する場合）
		// $insert .= '<meta property="fb:app_id" content="#####ここにappIDを入力">' . "\n";
		// app_idを設定しない場合ここまで消す.

		$allowed_html = array(
			'meta' => array(
				'property' => array(),
				'content'  => array(),
				'name'     => array(),
			),
		);
		echo wp_kses( $insert, $allowed_html );
	}
}
add_action( 'wp_head', 'col_outoput_ogp' );

/**
 * パスワード保護した記事の文言から「保護中：」を削除する
 *
 * @param string $title パラメーター.
 */
function col_remove_protected( $title ) {
	return '%s';
}
add_filter( 'protected_title_format', 'col_remove_protected' );

/**
 * パスワード保護に解除に関する文言を変更する
 */
function col_modify_password_text() {
	return '<div class="p-password">
	  <p>このコンテンツはパスワードで保護されています。<br> 閲覧するには以下にパスワードを入力してください。<p>
	  <form class="post_password" action="' . esc_url( home_url() . '/wp-login.php?action=postpass' ) . '" method="post">
	  <input name="post_password" type="password" size="24" />
	  <input class="c-btn c-btn-primary  u-hover-enlarge" type="submit" name="Submit" value="' . esc_attr( 'パスワード送信' ) . '" />
	  </form>
	  </div>';
}
add_filter( 'the_password_form', 'col_modify_password_text' );

/**
 * パスワード保護の有効期限を変更する
 *
 * @param string $timeout パラメーター.
 */
function col_customize_cockie_timeout( $timeout ) {
	// return time() + 2 * MINUTE_IN_SECONDS;
	return time() + 24 * HOUR_IN_SECONDS;
}
add_filter( 'post_password_expires', 'col_customize_cockie_timeout' );
