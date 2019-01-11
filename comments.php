<?php
/**
 * 留言模板
 * @package sketchy
 */

/*如果有密码保护，就不显示评论。*/
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
		<?php
			$comment_arg=array();
            $comment_arg['post_id']=get_the_ID();
            $comment_arg['count']='true';
            $comment_arg['user_id']=0;/*don't count for known users*/
            $comment_arg['type']='comment';
        ?>
			<?php printf('已有%1$s条评论', get_comments($comment_arg) ); ?>
		</h2>
		<?php get_template_part( 'template-parts/comment/list', is_page()?'page':'single' ); ?>

		<?php the_comments_pagination( array(
			'prev_text' => sketchy_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">前一页</span>',
			'next_text' => '<span class="screen-reader-text">后一页</span>' . sketchy_get_svg( array( 'icon' => 'arrow-right' ) ),
		) );

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php echo( '评论已关闭' ); ?></p>
	<?php else:
		get_template_part( 'template-parts/comment/input', 'fields' );
	endif; ?>

</div><!-- #comments -->
