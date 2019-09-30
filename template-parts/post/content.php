<?php
/**
 * 显示内容模块
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage SkyWarp2
 * @since 1.0
 * @version 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		/* 置顶图标 */
		if ( is_sticky() && is_home() ) :
			echo sketchy_get_svg( array( 'icon' => 'thumb-tack' ) );
		endif;
	?>
	<header class="entry-header">
		<?php
			if ( 'post' === get_post_type() ) :
				echo '<div class="entry-meta">';
						sketchy_entry_meta();
				echo '</div><!-- .entry-meta -->';
			endif;
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		?>
	</header><!-- .entry-header -->
    <div class="entry-content">
		<?php the_excerpt(); ?>
		<span class="grid-fade"></span>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
