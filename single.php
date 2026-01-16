<?php
/**
 * 显示单独文章
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Sketchy
 * @since 1.0
 * @version 7.8
 */

get_header(); 
$folder = get_template_directory();
	if (file_exists($folder."/inc/pewae-local.php")) {
		include_once($folder."/inc/pewae-local.php");
	}
?>


<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();
					if (function_exists('is_support_fancybox') && is_support_fancybox()) {
						enable_fancybox();
					}

					get_template_part( 'template-parts/post/content', 'single' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endwhile; // End of the loop.
				get_template_part( 'template-parts/post/single-navigation' );
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
