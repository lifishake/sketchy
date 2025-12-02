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
            'reverse_top_level'=>true,
            'max_depth'=>2,
            'reply_text'=> '@TA',
            'callback'=>'sketchy_page_comment',
        );
        wp_list_comments( $arg_list );
    ?>
</ol><!-- .comment-list -->

<?php
function sketchy_page_comment( $comment, $args, $depth ) {
?>
        <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php 
                            echo sketchy_get_ziface($comment);                         
                        ?>
                    </div><!-- .comment-author -->

                    <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php echo '评论审核中.'; ?></p>
                    <?php endif; ?>
                    <div class="comment-metadata">
                        <?php printf( '<b class="fn">%s</b>', $comment->comment_author ); ?>
                        <time datetime="<?php comment_time( 'c' ); ?>">
                                <?php echo sketchy_rel_comment_date(); ?>
                        </time>
                    </div>
                </footer><!-- .comment-meta -->
                <div class="comment-content">
                    <?php $parent_comment_id = $comment->comment_parent ;
                      if ( $parent_comment_id > 0 ) {
                        printf( '<span class="mention"> @%1s </span>', get_comment_author($parent_comment_id) );
                    } ?>
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->

            </article><!-- .comment-body -->
<?php
    }
