<?php
/**
 * 留言模板
 * @package bluefly
 */

/*如果有密码保护，就不显示评论。*/
if ( post_password_required() ) {
    return;
}
?>

<ol class="comment-list">
    <?php
        $arg_list = array(
            'style'      => 'ol',
            'short_ping' => true,
            'avatar_size'=> 60,
            'type'=>'comment',
            'callback'=>'sketchy_single_comment',
        );
        wp_list_comments( $arg_list );
    ?>
</ol><!-- .comment-list -->

<?php
function sketchy_single_comment( $comment, $args, $depth ) {
    if ($comment->user_id == 0) {
        $comment_author_url = apply_filters('comment_url',$comment->comment_author_url, $comment->comment_ID );
    } else {
        $comment_author_url = $comment->comment_author_url;
    }
    
    //$avatar_img = get_avatar( $comment, $args['avatar_size'] );
    $ziface = sketchy_get_ziface($comment);
    $parent_comment_id = $comment->comment_parent ;
?>
        <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php if ($comment_author_url) {
                                printf('<a class="url" href="%1$s" target="_blank" rel="external nofollow" title="%2$s">%3$s</a>', $comment_author_url, $comment->comment_author_name, $ziface);
                            } else {
                                //echo $avatar_img;
                                echo $ziface;
                            }
                        ?>
                    </div><!-- .comment-author -->

                    <div class="comment-metadata">
                        <?php 
                        if ($comment->user_id>0) {
                            $comment_author_url = "";
                        }
                        if (''===$comment_author_url) {
                            printf( '<b class="fn">%s</b>', $comment->comment_author_name );
                        }
                        else {
                            printf( '<b class="fn author-url"><a href="%1$s" target="_blank" rel="external nofollow" class="url">%2$s</a></b>', $comment_author_url, $comment->comment_author_name );
                        }
                        if ( $parent_comment_id > 0 ) {
                            printf( '<span class="mention"> @%1$s </span>', get_comment_author($parent_comment_id) );
                        }
                        ?>
                        <time datetime="<?php comment_time( 'c' ); ?>">
                            <?php echo sketchy_rel_comment_date(); ?>
                        </time><?php
                        comment_reply_link( array_merge( $args, array(
                            'add_below' => 'div-comment',
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                            'reply_text'=> '@TA',
                            'before'    => '<span class="reply">',
                            'after'     => '</span>'
                        ) ) );
                        ?>
                    </div><!-- .comment-metadata -->

                    <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php echo '评论审核中.'; ?></p>
                    <?php endif; ?>
                </footer><!-- .comment-meta -->

                <div class="comment-content">
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->

            </article><!-- .comment-body -->
<?php
    }
