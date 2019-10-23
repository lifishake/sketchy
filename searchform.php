<?php
/**
 * 搜索框模板
 *
 * @package WordPress
 * @subpackage Sketchy
 * @since 1.0
 * @version 1.0
 */
?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $unique_id; ?>">
		<span class="screen-reader-text">查找</span>
	</label>
	<input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="输入关键字 &hellip;" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit"><?php echo sketchy_get_svg( array( 'icon' => 'search' ) ); ?><span class="screen-reader-text">搜索</span></button>
</form>
