<?php
/**
 * 页面模板
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Sketchy
 * @since 1.0
 * @version 1.0
 */
global $page_type;
$page_type = 'book';
get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/page/content', 'oblong' );
			endwhile; // End of the loop.
			?>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
