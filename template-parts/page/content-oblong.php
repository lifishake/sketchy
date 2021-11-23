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
global $page_type;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( "page-no-edge" ); ?>>
	<header class="entry-header">
	<?php
		the_title( '<h1 class="screen-reader-text">', '</h1>' ); 
	?>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php
		if('movie' == $page_type || 'book' == $page_type || 'game' == $page_type) {
			bddb_the_gallery($page_type);
		}else{
			the_content();
		}
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
