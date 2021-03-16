<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */




$rank_first_time        = get_field( 'rank_first_time' );
$rank_last_time         = get_field( 'rank_last_time' );
$title_01               = get_field( 'title_01' );
$comment_01             = get_field( 'comment_01' );
$score_01               = get_field( 'score_01' );
$total_score_first_time = get_field( 'total_score_first_time' );
$total_score_last_time  = get_field( 'total_score_last_time' );
$message                = get_field( 'message' );
$name                   = get_field( 'name' );
$date_start             = get_field( 'date_start' );
$date_end               = get_field( 'date_end' );

// echo get_field_object( 'rank_first_time' )['label'] . $rank_first_time . '<br>';
// echo get_field_object( 'rank_last_time' )['label'] . $rank_last_time . '<br>';
// echo get_field_object( 'title_01' )['label'] . $title_01 . '<br>';
// echo get_field_object( 'comment_01' )['label'] . $comment_01 . '<br>';
// echo get_field_object( 'score_01' )['label'] . $score_01 . '<br>';
// echo get_field_object( 'total_score_first_time' )['label'] . $total_score_first_time . '<br>';
// echo get_field_object( 'total_score_last_time' )['label'] . $total_score_last_time . '<br>';
// echo get_field_object( 'message' )['label'] . $message . '<br>';
// echo get_field_object( 'name' )['label'] . $name . '<br>';
// echo get_field_object( 'date_start' )['label'] . $date_start . '<br>';
// echo get_field_object( 'date_end' )['label'] . $date_end . '<br>';

$detail_array = array(
	array(
		'title'   => $title_01,
		'comment' => $comment_01,
		'score'   => $score_01,
	),
	array(
		'title'   => $title_01,
		'comment' => $comment_01,
		'score'   => $score_01,
	),
	array(
		'title'   => $title_01,
		'comment' => $comment_01,
		'score'   => $score_01,
	),
	array(
		'title'   => $title_01,
		'comment' => $comment_01,
		'score'   => $score_01,
	),
	array(
		'title'   => $title_01,
		'comment' => $comment_01,
		'score'   => $score_01,
	),
	array(
		'title'   => $title_01,
		'comment' => $comment_01,
		'score'   => $score_01,
	),
	array(
		'title'   => $title_01,
		'comment' => $comment_01,
		'score'   => $score_01,
	),
	array(
		'title'   => $title_01,
		'comment' => $comment_01,
		'score'   => $score_01,
	),
	array(
		'title'   => $title_01,
		'comment' => $comment_01,
		'score'   => $score_01,
	),
	array(
		'title'   => $title_01,
		'comment' => $comment_01,
		'score'   => $score_01,
	)
);
?>

<?php get_header(); ?>
<header id="l-header" class="p-header">
	<h1 class="p-header__txt">あなたは見習いライターから、「名人ライター」になりました！</h1>
</header>


<main id="l-container">
	<div class="p-flex">
		<section id="l-left">
			<div class="p-chart">
				<h2 class="p-chart__title">初回と最終回のスコア比較</h2>
				<div class="p-chart__graph">
					<canvas id="myChart"></canvas>
				</div>
				<div class="p-chart__score">
					<div class="p-chart__last">
						<p class="p-chart__last-title">総合スコア</p>
						<p class="p-chart__last-score">82</p>
						<p class="p-chart__last-small">(最終回)</p>
					</div>
					<div class="p-chart__first">
						<p class="p-chart__first-score">46</p>
						<p class="p-chart__first-small">(初回)</p>
					</div>
				</div>
			</div>
		</section>
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
	<section id="l-bottom">
		<div class="p-bottom-contents p-flex">
			<div class="p-meesage">
				<h2 class="p-meesage__title">担当者からのメッセージ</h2>
				<p class="p-meesage__txt"><?php echo esc_html( $message ); ?></p>
			</div>
			<div class="p-meta">
				<p class="p-meta__name"><?php echo esc_html( $name ); ?></p>
				<p class="p-meta__date"><?php echo esc_html( $date_start . '〜' . $date_end ); ?></p>
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

<script>
	var ctx = document.getElementById("myChart").getContext("2d");
	ctx.canvas.width = 710;
	ctx.canvas.height = 710;
	var myLineChart = new Chart(ctx, {
	type: "radar",
	data: {
	labels: [
		["1.文章は", "読みやすいか"],
		["2.見た目は", "綺麗か"],
		["3.誤字脱字は", "ないか"],
		["4.先読み", "できているか"],
		["5.キーワードに", "適しているか"],
		["6.記事タイトルは", "魅力的か"],
		["7.構成は適切か"],
		["8.リンクの使い", "方は適切か"],
		["9.スマホは", "最適化されてるか"],
		["10.初めて読む読者", "でも理解できるか"]
	],
	datasets: [
		{
		label: "初回",
		data: [4, 4, 4, 2, 5, 6, 7, 8, 8, 6],
		borderWidth: 3,
		pointBackgroundColor: "rgba(57,210,214,1)",
		backgroundColor: "rgba(57,210,214,0.2)",
		borderColor: "rgba(57,210,214,1)"
		},
		{
		label: "最終回",
		data: [6, 6, 7, 7, 6, 8, 9, 9, 9, 10],
		borderWidth: 3,
		pointBackgroundColor: "rgba(22,36,167,1)",
		backgroundColor: "rgba(227,243,255,0.2)",
		borderColor: "rgba(22,36,167,1)"
		}
	]
	},
	options: {
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
