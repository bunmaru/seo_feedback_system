<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

if ( ! is_single() ) {
	get_template_part( 'parts/sns' );} ?>
<footer id="l-footer" class="p-footer u-bg-dark">
	<div class="l-contents">
		<div class="p-footer-logo-area">
			<div class="p-footer-logo-title">
				<a class="p-footer-logo-link" href="<?php echo esc_url( home_url() ); ?>">
					<?php bloginfo( 'name' ); ?>
				</a>
			</div>
			<a href="https://wunderstand.net/" target="_blank" class="p-footer-powerd">
				Powered by Bond
			</a>
		</div>
	</div>
</footer>
<script>
	const trigger = document.getElementById('js-menu-btn');
	if(trigger){
		trigger.addEventListener('click', function(){
			const target = document.getElementById('js-sp-nav');
			target.classList.toggle('is-menu-open');
		}, false);
	}
</script>
<?php wp_footer(); ?>

</body>
</html>
