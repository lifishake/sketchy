<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Sketchy
 * @since 1.0
 * @version 1.0
 */

?>
<?php $limit = is_page('my-tag-cloud') || is_page('archives') || is_page('archive') || is_page('about');?>

<article id="post-<?php the_ID(); ?>" <?php post_class($limit ? "page-no-edge":"" ); ?>>
	<header class="entry-header">
		<?php if (!$limit) {
				the_title( '<h1 class="entry-title">', '</h1>' ); 
		}
		else{
			the_title( '<h1 class="screen-reader-text">', '</h1>' ); 
		}?>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php
			the_content();
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
