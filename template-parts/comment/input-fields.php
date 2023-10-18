<?php
/**
 * 留言框
 * @package sketchy
 */
?>
<div id="respond" class="comment-respond">
<h3 id="reply-title" class="comment-reply-title">
<small>
<?php cancel_comment_reply_link( '取消回复' ); ?>
</small>
</h3>
<?php if (function_exists('apip_commentquiz_form')) {
    apip_commentquiz_form();
}?>
<form method="post" id="commentform" class="comment-form" novalidate >
<?php if( is_user_logged_in() ) : ?>
    <p class="logged-in-as">已登录</p>
<?php else : ?>
    <?php
        $commenter = wp_get_current_commenter();
        if ( $commenter ) {
            $cookie = esc_attr($commenter['comment_author']);
            $email = esc_attr($commenter['comment_author_email']);
            $url = esc_attr($commenter['comment_author_url']);
        }
        if ( $cookie ) {
            $comment_part.= sprintf('<div class="form_row"><span> %s <i class="show-form " >[编辑]</i>， 欢迎回来。</span></div>', $cookie) ;
            echo $comment_part;
        }
        else {
            echo '<div class="form_row"><span>你好，新朋友。留言前请先填写<b>昵称</b>和<b>邮箱</b>。</span></div>';
        }
    ?>
    <div id="author_info">
    <p class="comment-form-author"><input id="author" name="author" type="text"  size="30" placeholder="昵称（必填）" value="<?php echo esc_attr($cookie); ?>" maxlength="245" aria-required='true' required='required' /></p>
    <p class="comment-form-email"><input id="email" name="email" type="email"  size="30" placeholder="邮箱（必填，保密）" value="<?php echo esc_attr($email); ?>" maxlength="100" aria-describedby="email-notes" aria-required='true' required='required' /></p>
    <p class="comment-form-url"><input id="url" name="url" type="url"  size="30" placeholder="网址（选填）" value="<?php echo esc_attr($url); ?>" maxlength="200" /></p>
    </div>
<?php endif; ?>
<p class="comment-form-comment" ><textarea id="comment" name="comment" cols="45" rows="8" placeholder="<?php echo apply_filters('apip_placeholder_text','请不要留下无趣的东西浪费大家时间。');/*配合apip插件!*/?>" maxlength="65525" aria-required="true" required="required"></textarea></p><p class="form-submit">
<input name="submit" type="submit" id="reload" class="submit" value="提交留言" wpnonce="<?php echo wp_create_nonce('no-comment-is-best-comment'); ?>" />
<input type='hidden' name='comment_post_ID' value='<?php echo esc_attr($post->ID); ?>' id='comment_post_ID' />
<input type='hidden' name='comment_parent' id='comment_parent' value='0' />
</form><!-- #comments -->
</div><!-- #respond -->
