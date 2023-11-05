<?php
/**
 * 主模板
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Sketchy
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<?php if ( is_home() && ! is_front_page() ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php single_post_title(); ?></h1>
		</header>
	<?php else : ?>
	<header class="page-header">
		<h2 class="page-title screen-reader-text"><?php echo( '文章列表' ); ?></h2>
	</header>
	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/post/content', get_post_format() );

				endwhile;

				the_posts_pagination( array(
					'prev_text' => '&larr;<span class="screen-reader-text">上一页</span>',
					'next_text' => '<span class="screen-reader-text">下一页</span>&rarr;',
					'before_page_number' => '<span class="meta-nav screen-reader-text">页</span>',
					'mid_size' => 2,
				) );
				/*the_posts_navigation();*/

			else :

				get_template_part( 'template-parts/post/content', 'none' );

			endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
