<?php
/**
 * 显示单独文章
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage SkyWarp2
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/post/content', 'single' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					$args = array(
						'prev_text' => '<span class="nav-title"><span class="nav-title-icon-wrapper">' . sketchy_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
						'next_text' => '<span class="nav-title">%title<span class="nav-title-icon-wrapper">' . sketchy_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
						'screen_reader_text'=>'文章导航'
					);
					if ( function_exists('apip_get_post_navagation') ){
						apip_get_post_navagation( $args );
					}
					else {
						the_post_navigation( $args );
					}
					

				endwhile; // End of the loop.
				get_template_part( 'template-parts/post/more-recommended' );
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
