<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage SkyWarp2
 * @since 1.0
 * @version 1.0
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php echo( '什么也没有' ); ?></h1>
	</header>
	<div class="page-content">
			<p><?php echo( '什么都没有。试试搜索吧。' ); ?></p>
			<?php get_search_form(); ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
