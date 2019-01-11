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
?>
        <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
                    </div><!-- .comment-author -->

                    <div class="comment-metadata">
                        <?php
                            /* translators: %s: comment author link */
                            printf( '<b class="fn author-url">%s</b>', get_comment_author_link( $comment ) );
                        ?>
                        <time datetime="<?php comment_time( 'c' ); ?>">
                            <?php echo sketchy_rel_comment_date(); ?>
                        </time>
                        <?php $parent_comment_id = $comment->comment_parent ;
                          if ( $parent_comment_id > 0 ) {
                            printf( '<span class="mention"> @%1s </span>', get_comment_author($parent_comment_id) );
                        }
                        comment_reply_link( array_merge( $args, array(
                            'add_below' => 'div-comment',
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                            'reply_text'=> '回复',
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
