<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage SkyWarp2
 * @since 1.0
 * @version 1.0
 */

?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Top Menu">
	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false"><?php echo sketchy_get_svg( array( 'icon' => 'bars' ) ); echo sketchy_get_svg( array( 'icon' => 'close' ) ); ?></button>
	<?php wp_nav_menu( array(
		'theme_location' => 'top',
		'menu_id'        => 'top-menu',
	) ); ?>


		<a href="" rel="tohead" class="menu-scroll-up"><?php echo sketchy_get_svg( array( 'icon' => 'square-up' ) ); ?><span class="screen-reader-text"><?php echo( '回到顶部' ); ?></span></a>

</nav><!-- #site-navigation -->
