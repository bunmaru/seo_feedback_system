<?php
/**
 * Collection WordPress Theme
 *
 * @package Collection
 */

// パスワードラベル表示.
if ( post_password_required( $post->ID ) ) : // パスワードロックされている場合. ?>
	<div class="p-lock-label p-lock-label-islock ">
		<i class="fas fa-lock"></i>
		<span class="p-lock-label-text">ロックされています</span>
	</div>
<?php elseif ( ! empty( $post->post_password ) ) : // (パスワードロックされていないかつ)パスワードが設定されている場合. ?>
	<div class="p-lock-label">
		<i class="fas fa-unlock"></i>
		<span class="p-lock-label-text">パスワード解除済み</span>
	</div>
<?php endif; ?>
