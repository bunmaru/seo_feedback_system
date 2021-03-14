<?php
/**
 * Collection WordPress Theme
 *
 * @package Perakoya
 */

/**
 * テーマカスタマイザー を表示する
 *
 * @param object $wp_customize パラメーター.
 */
function col_theme_customize( $wp_customize ) {

	// セクションの追加.
	$wp_customize->add_section(
		'header_section',
		array(
			'title'       => 'ヘッダー画像設定', // セクションのタイトル.
			'priority'    => 58, // セクションの位置.
			'description' => 'ヘッダー画像の設定を行います。', // セクションの説明.
		)
	);
	$wp_customize->add_section(
		'profile_section',
		array(
			'title'       => 'プロフィール', // セクションのタイトル.
			'priority'    => 59, // セクションの位置.
			'description' => 'プロフィールの設定を行います。', // セクションの説明.
		)
	);

	/*
	* 設定項目の作成
	*/
	// ヘッダー画像.
	$wp_customize->add_setting(
		'header_img',
		array(
			'default'           => get_template_directory_uri() . '/images/header.png',
			'sanitize_callback' => 'col_sanitize_file',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'header_img',
			array(
				'label'       => 'ヘッダー画像',
				'section'     => 'header_section',
				'settings'    => 'header_img',
				'description' => 'ヘッダー画像を設定してください。<br>(推奨サイズ1920px-410px)',
			)
		)
	);

	// プロフィール画像.
	$wp_customize->add_setting(
		'profile_img',
		array(
			'default'           => get_template_directory_uri() . '/images/profile.png',
			'sanitize_callback' => 'col_sanitize_file',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'profile_img',
			array(
				'label'       => 'プロフィール画像',
				'section'     => 'profile_section',
				'settings'    => 'profile_img',
				'description' => 'プロフィール画像を設定してください。',
			)
		)
	);

	// プロフィールテキスト.
	$wp_customize->add_setting(
		'profile_name',
		array(
			'default'           => 'Bond Design',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'profile_name',
		array(
			'label'       => '名前',
			'section'     => 'profile_section',
			'setting'     => 'profile_name',
			'type'        => 'text',
			'description' => '名前を入力してください',
		)
	);

	// プロフィール住所.
	$wp_customize->add_setting(
		'profile_city',
		array(
			'default'           => 'Japan',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'profile_city',
		array(
			'label'       => '住所',
			'section'     => 'profile_section',
			'setting'     => 'profile_city',
			'type'        => 'text',
			'description' => '住所を入力してください。',
		)
	);

	// プロフィールテキスト.
	$wp_customize->add_setting(
		'profile_text',
		array(
			'default'           => 'WEBデザイン, フロントエンド, wordpressが得意です。WEBデザイナーとして企業に勤めるかたわら、フリーランスとしてもデザインやコーディングなどの仕事もしています。',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'profile_text',
		array(
			'label'       => 'プロフィール文',
			'section'     => 'profile_section',
			'setting'     => 'profile_text',
			'type'        => 'text-area',
			'description' => 'プロフィール文を入力してください。',
		)
	);

	// プロフィールURL.
	$wp_customize->add_setting(
		'profile_url',
		array(
			'default' => '',
		)
	);
	$wp_customize->add_control(
		'profile_url',
		array(
			'label'       => 'URL',
			'section'     => 'profile_section',
			'setting'     => 'profile_url',
			'type'        => 'url',
			'description' => 'プロフィールページのURLをドメインの後から入力してください。<br> 例) profile/',
		)
	);
}
add_action( 'customize_register', 'col_theme_customize' );

/**
 * テーマカスタマイザーの内容をサニタイズする
 *
 * @param object $input パラメーター.
 * @param object $setting パラメーター.
 */
function col_sanitize_file( $input, $setting ) {
	// ファイル用.
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif'          => 'image/gif',
		'png'          => 'image/png',
		'svg'          => 'image/svg+xml',
		'bmp'          => 'image/bmp',
		'tif|tiff'     => 'image/tiff',
		'ico'          => 'image/x-icon',
	);
	$file  = wp_check_filetype( $input, $mimes );
	return ( $file['ext'] ? $input : $setting->default );
}

/**
 * テーマカスタマイザーで設定されたコンテンツを取得する
 * ヘッダー画像
 */
function col_get_headerimg_url() {
	return esc_url( get_theme_mod( 'header_img' ) );
}

/**
 * テーマカスタマイザーで設定されたコンテンツを取得する
 * プロフィール画像
 */
function col_get_profileimg_url() {
	return esc_url( get_theme_mod( 'profile_img' ) );
}

/**
 * テーマカスタマイザーで設定されたコンテンツを取得する
 * プロフィール住所
 */
function col_get_profile_city() {
	return get_theme_mod( 'profile_city' );
}

/**
 * テーマカスタマイザーで設定されたコンテンツを取得する
 * プロフィール名前
 */
function col_get_profile_name() {
	return get_theme_mod( 'profile_name' );
}

/**
 * テーマカスタマイザーで設定されたコンテンツを取得する
 * プロフィールテキスト
 */
function col_get_profile_text() {
	return get_theme_mod( 'profile_text' );
}

/**
 * テーマカスタマイザーで設定されたコンテンツを取得する
 * プロフィールURL
 */
function col_get_profile_url() {
	return get_theme_mod( 'profile_url' );
}
