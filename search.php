<?php
/**
 * 搜索结果页
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage SkyWarp2
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">

	<header class="page-header">
		<?php if ( have_posts() ) : ?>
			<h1 class="page-title"><?php printf( '关键字『%s』的搜索结果：', get_search_query() ); ?></h1>
		<?php else : ?>
			<h1 class="page-title"><?php echo( '一无所获。' ); ?></h1>
		<?php endif; ?>
	</header><!-- .page-header -->

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/post/content', 'excerpt' );

			endwhile; // End of the loop.

			the_posts_pagination( array(
				'prev_text' => sketchy_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">前一页</span>',
				'next_text' => '<span class="screen-reader-text">后一页</span>' . sketchy_get_svg( array( 'icon' => 'arrow-right' ) ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">页</span>',
			) );

		else : ?>

			<p><?php echo( '没找到你想要的。换个关键字试试吧！' ); ?></p>
			<?php
				get_search_form();

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
