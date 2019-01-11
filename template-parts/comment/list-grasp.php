<?php
/**
 * 无诚意留言模板
 * @package bluefly
 */

/**
 * 作用: 无诚意留言列表.调用WP函数
 * 来源: 破袜子原创
 */
    if ( !is_single() ) {
        return;
    }
    $comment_arg=array();
    $comment_arg['post_id']=get_the_ID();
    $comment_arg['type']='senseless';
    $senselesses = get_comments($comment_arg);
    if( count($senselesses) === 0 ) {
        return;
    }
    ?>
<div class="no-order">
<div class="assistive-text noselect"> 路过的人 </div>
<ol class="grasp-list">
<?php
    foreach ($senselesses as $comment ) { ?>
        <li id="comment-<?php echo $comment->comment_ID; ?>" <?php comment_class( 'grasp' ); ?>>
            <div class="comment-grasp vcard">
                <?php echo '<a class="x7" href="'.$comment->comment_author_url.'" rel="external nofollow" >'. get_avatar( $comment->comment_author_email, 24).'</a>' ; ?>
            </div>
        </li>
    <?php }?>
</ol></div><!-- .no-order -->
