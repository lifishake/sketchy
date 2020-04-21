<?php

/**
 * ajax_comment后的回调函数，以及自定义的comment回调显示函数。
 * 自定义comment回调的原因是看原版显示格式不顺眼。
 * 本文件原型来自大发提供的do.php，有大幅度增删改。原始URL：https://fatesinger.com/59
 * @package sketchy
 */

//追加回调入口
add_action('wp_ajax_nopriv_ajax_comment', 'ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'ajax_comment_callback');

/**
 * 作用: AJAX提交过程的共同函数。
 * 		其实大发原版也是基于WP的comment的。
 * 来源: 破袜子根据大发的代码修改
 */
function sketchy_newcomment( ) {
    $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
    if ( is_wp_error( $comment ) ) {
        $code = $comment->get_error_code();
        $err_str = "异常评论";
        if ( ! empty( $code ) ) {
            switch($code) {
                case 'comment_id_not_found':
                $err_str = "评论不存在!";
                break;
                case 'comment_closed':
                $err_str = "评论已关闭!";
                break;
                case 'comment_on_trash':
                $err_str = "评论已被移至垃圾箱!";
                break;
                case 'comment_on_draft':
                $err_str = "该文章无权限评论!";
                break;
                case 'comment_on_password_protected':
                $err_str = "该文章已被保护!";
                break;
                case 'not_logged_in':
                $err_str = "对不起，评论前需登录!";
                break;
                case 'comment_author_column_length':
                $err_str = "提交失败，昵称超长!";
                break;
                case 'comment_author_email_column_length':
                $err_str = "提交失败，邮箱超长!";
                break;
                case 'comment_author_url_column_length':
                $err_str = "提交失败，网址超长!";
                break;
                case 'comment_content_column_length':
                $err_str = "提交失败，评论内容超长!";
                break;
                case 'require_name_email':
                $err_str = "对不起，昵称和邮箱不可为空!";
                break;
                case 'require_valid_email':
                $err_str = "请输入正确的邮箱格式!";
                break;
                case 'require_valid_comment':
                $err_str = "对不起，评论内容不可为空!";
                break;
                case 'comment_save_error':
                $err_str = "异常，评论保存失败!";
                break;
                case 'comment_flood':
                $err_str = "评论太频繁了，慢一点老铁!";
                break;
                case 'comment_duplicate':
                $err_str = "检测到重复评论!";
                break;
                default:
                break;
            }
        } 
        ajax_comment_err($err_str);
        exit;
    } 
    $user = wp_get_current_user();
    do_action( 'set_comment_cookies', $comment, $user );
    $GLOBALS['comment'] = $comment;
	return $comment;
}

/**
 * 作用: 留言的回调显示
 * 来源: 破袜子原创
 */
function sketchy_additional_comment_show( $comment ) {
    $success = 0;
    if ( '0' == $comment->comment_approved )
    {
        ajax_comment_err("评论审核中...");
        $success = 20;
    }
    if ($comment->comment_author_email == "2b@pewae.com")
    {
        $success = 10;
    }
	?>
    <li <?php comment_class(); ?>>
        <article class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php echo get_avatar( $comment->comment_author_email, $size = '100')?>
                </div>
                <div class="comment-metadata">
                    <span><b class="fn author-url"><?php echo get_comment_author_link(); ?></b>
					</span>
                    <time datetime="<?php comment_time( 'c' ); ?>">刚刚</time>
                </div>
            </footer>
            <div class="comment-content">
                <?php comment_text(); 
                if ($success===10) {
                    echo("</br><p><em><b>博主看你发广告太辛苦，替你换了个昵称。</br>惊不惊喜，意不意外？</b></em></p>");
                }
                else if ($success===20) {
                    echo("</br><p>检测到首次留言，评论审核中...</p>");
                }
                ?>
            </div>
        </article>
    </li>
	<?php
}

/**
 * 作用: 评论提交后的回调函数，
 * 来源: 大发（bigfa）
 * URI: https://fatesinger.com/59
 */
function ajax_comment_callback(){
	$comment_author_email ;
    if ( ! wp_verify_nonce($_POST['nonce'],'no-comment-is-best-comment') ) {
        die();
    }
	$comment_author_email = sketchy_newcomment( );
	sketchy_additional_comment_show($comment_author_email);

    die();
}

/**
 * 作用: ajax效果时，弹出的错误窗口
 * 来源: 大发
 */
function ajax_comment_err($a) {
    header('HTTP/1.0 500 Internal Server Error');
    header('Content-Type: text/plain;charset=UTF-8');
    echo $a;
    exit;
}
