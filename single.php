<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

$rank_last_time        = get_field( 'rank_last_time' );// 最終回時の称号.
$message               = get_field( 'message' );// 担当者からのメッセージ.
$name                  = get_field( 'name' );// 受講者名前.
$date_start            = get_field( 'date_start' );// 受講開始日.
$date_end              = get_field( 'date_end' );// 受講完了日.
$score_last_time_array = array();// 終了時の各点数(配列).
$title_array           = array();// 各項目のタイトル.

// タイトル、コメント、スコアを配列に格納(項目削除と順序変更対応により、1,6,5,8,4の順で格納).
$detail_array = array();
$output_index = array( '01', '06', '05', '08', '04' );

$count = 1;
foreach ( $output_index as $idx ) {
	$num                     = sprintf( '%02d', $count );// 二桁に整形する.
	$score_last_time_array[] = get_field( 'score_' . $idx );
	$target_title            = get_field_object( 'comment_' . $idx )['label'];
	$title_array[]           = $num . '.' . $target_title;

	// チャートの右側のリスト表示用の配列.
	$detail_array[] = array(
		'title'   => $num . '.' . str_replace( '<br>', '', $target_title ), // brタグを除去して格納.
		'comment' => get_field( 'comment_' . $idx ),
		'score'   => get_field( 'score_' . $idx ),
	);
	$count++;
}

// 総合スコアの計算.
$total_score_last_time = 0;
foreach ( $score_last_time_array as $score ) {
	$total_score_last_time += intval( $score );
}

?>

<?php get_header(); ?>
<header id="l-header" class="p-header">
	<h1 class="p-header__txt">
		あなたは <span class="p-header__strong">
			<?php echo esc_html( $rank_last_time ); ?>
		</span> です。
	</h1>
</header>

<main id="l-container">
	<div class="l-container__inn">

		<!-- チャート部分 -->
		<section id="l-left">
			<div class="p-chart">
				<!--<h2 class="p-chart__title">最終回スコア</h2>-->
				<div class="p-chart__graph">
					<canvas id="myChart"></canvas>
				</div>
				<div class="p-chart__score">
					<div class="p-chart__last">
						<p class="p-chart__last-title">総合スコア</p>
						<p class="p-chart__last-score"><?php echo esc_html( $total_score_last_time ); ?></p>
						<!--<p class="p-chart__last-small">(最終回)</p>-->
					</div>
				</div>
				<!--<div class="p-chart-logo">
					<img src="<?php echo esc_html( get_template_directory_uri() . '/images/logo.svg' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
				</div>-->
			</div>
		</section>

		<!-- リスト部分 -->
		<section id="l-right">
			<div class="p-right-contents">
			<div class="p-list">
				<?php
				foreach ( $detail_array as $detail ) :
					?>
					<div class="p-flex p-list__box">
						<div class="p-list__title-area">
							<p class="p-list__title"><?php echo esc_html( $detail['title'] ); ?></p>
							<p class="p-list__comment"><?php echo esc_html( $detail['comment'] ); ?></p>
						</div>
						<p class="p-list__score"><?php echo esc_html( $detail['score'] ); ?></p>
					</div>
					<?php
				endforeach;
				?>
			</div>
			</div>
		</section>
	</div>

	<!-- ボトム部分 -->
	<section id="l-bottom">
		<div class="p-bottom-contents p-flex">
			<div class="p-meesage">
				<!--<h2 class="p-meesage__title"><i class="far fa-comment"></i><span>担当者からのメッセージ</span></h2>
				<p class="p-meesage__txt"><?php echo wp_kses_post( $message ); ?></p>-->
			</div>
			<div class="p-meta">
				<!--<p class="p-meta__name"><?php echo esc_html( $name ); ?></p>
				<p class="p-meta__date">受講期間(<?php echo esc_html( $date_start . '〜' . $date_end ); ?>)</p>-->
				<div class="p-logo">
					<a class="p-logo__link" href="<?php echo esc_url( home_url() ); ?>">
						<img src="<?php echo esc_html( get_template_directory_uri() . '/images/logo.svg' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
					</a>
				</div>
			</div>

		</div>
	</section>

</main>
<?php get_footer(); ?>

<?php

// chart.jsの設定用のjsonを作成する.
$score_last_time_json = wp_json_encode( $score_last_time_array );// 終了時の点数(json).

// 項目名の設定。
// ラベル項目名に<br>タグがあった場合、改行する
// chart.jsの使用上、項目名に改行を入れるためには多重配列にする必要があるのでその対応も行う.
$title_array_br = array();
foreach ( $title_array as $title_string ) {
	$title_array_br[] = explode( '<br>', $title_string );
}
$title_array_json = wp_json_encode( $title_array_br, JSON_UNESCAPED_UNICODE );// 終了時の点数(json).

?>
<script>
	var ctx = document.getElementById("myChart").getContext("2d");
	ctx.canvas.width = 660;
	ctx.canvas.height = 660;
	var myLineChart = new Chart(ctx, {
	type: "radar",
	data: {
		labels: <?php echo $title_array_json; ?>,
		datasets: [
			{
				label: "最終回",
				data: <?php echo $score_last_time_json; ?>,
				borderWidth: 3,
				pointBackgroundColor: "rgba(22,36,167,1)",
				backgroundColor: "rgba(227,243,255,0.2)",
				borderColor: "rgba(22,36,167,1)"
			}
		]
	},
	options: {
		legend: {
			display: false
		},
		scale: {
			pointLabels: {
				fontSize: 16, // 文字の大きさ
				fontColor: "#5a5a5a" // 文字の色
			},
			legend: {
				display: false
			},
			ticks: {
				suggestedMax: 10,
				suggestedMin: 0,
				stepSize: 1,
				backdropColor: "rgba(255, 255, 255, 0)",
				fontColor: "#B7B7B7",
				callback: function (value, index, values) {
					return value + "点";
				}
			},
			angleLines: {
				// 軸（放射軸）
				display: true,
				color: "#CECECE"
			},
			gridLines: {
				// 補助線（目盛の線）
				display: true,
				color: "#CECECE"
			}
		}
	}
});
</script>
