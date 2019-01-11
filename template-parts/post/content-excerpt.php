<?php
/**
 * 用来显示摘要。目前只在search的时候使用
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

	<header class="entry-header">
			<div class="entry-meta">
				<?php
					sketchy_entry_meta();
				?>
			</div><!-- .entry-meta -->

		<?php
			//替换the_title,为了高亮标题
            mb_regex_encoding("UTF-8");
			$keyword = get_search_query();
			$text = get_the_title();
			$text = mb_ereg_replace($keyword, '<span class="highlight">'.$keyword.'</span>', $text); //mb_ereg_replace是多语言支持(utf-8)函数
			$title = sprintf('<h2 class="entry-title"><a href="%1$s" rel="bookmark">%2$s</a></h2>',esc_url( get_permalink()),$text );
			echo $title; 
		?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_sketchy_excerpt(); //来自template-tag ?>
	</div><!-- .entry-summary -->

</article><!-- #post-## -->
