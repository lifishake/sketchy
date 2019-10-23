<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package WordPress
 * @subpackage Sketchy
 * @since 1.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function sketchy_body_classes( $classes ) {

	// Add class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add class for one or two column page layouts.
	if ( is_page() || is_archive() ) {
			$classes[] = 'page-one-column';
	}

	if (!is_single()) {
		return $classes;
	}
	$dices = 13;
	$id = get_the_ID()%$dices;
	$classes[] = "bgnum-".$id;
	return $classes;
}
add_filter( 'body_class', 'sketchy_body_classes' );

/*
* 作用: 获得缩略图链接
* 参数: $ID post_ID，为空时为当前post（必须在the_loop内）。
* 参数: $type 缩略图种类。目前有两种：sketchy-featured-image是题头图片，sketchy-related是相关小size的图片。
*/
function sketchy_get_thumbnail_str($ID = "",$type="sketchy-featured-image") {
    if ( !is_singular() )
		return '';
	$thumbnail = "";
    if ( has_post_thumbnail($ID) ) :
        $post_image_id = get_post_thumbnail_id($ID);
        if ($post_image_id) 
        {
            $thumbnails = wp_get_attachment_image_src( $post_image_id, $type, false);
            if ($thumbnails) (string)$thumbnail = $thumbnails[0];
		}
	endif;
    return $thumbnail;
}

function sketchy_replace_header_image( $html, $header, $attr )
{
	$new_src = sketchy_get_thumbnail_str();
	if ( empty($new_src) || $new_src === '' )
	{
		return $html;
	}

	$html = '<img';

	foreach ( $attr as $name => $value ) {
		if ( $name === 'src' ) {
			$value = $new_src;
		}
		$html .= ' ' . $name . '="' . $value . '"';
	}

	$html .= ' />';
	return $html;
}
//add_filter('get_header_image_tag','sketchy_replace_header_image',10,3);

function sketchy_get_prev_post() {
	//TBD
	return get_previous_post();
}

function sketchy_get_next_post() {
	//TBD
	return get_next_post();
}

function  sketchy_add_single_inline_css() {
	if (!is_single()) {
		return;
	}
	global $g_prev_post;
	global $g_next_post;
	global $g_related;
	global $g_sameday;
	$g_prev_post = NULL;
	$g_next_post = NULL;
	$got_ids = array();
	$prev_post = sketchy_get_prev_post();
	if ( !empty($prev_post) ) {
		$got_ids[] = $prev_post->ID;
		$g_prev_post = $prev_post;
	}

	$next_post = sketchy_get_next_post();
	if ( !empty($next_post) ) {
		$got_ids[] = $next_post->ID;
		$g_next_post = $next_post;
	}

	if (function_exists('apip_get_related_posts') && function_exists('apip_get_sameday_his_posts')){
		$sameday = apip_get_sameday_his_posts(3,"NEARBY");
		$exclude = array_column($sameday, "object_id");
		$related = apip_get_related_posts(6 - count($exclude),$exclude);
		$g_related = $related;
		$g_sameday = $sameday;
		foreach ($related as $r) {
			$got_ids[]=$r["object_id"];
		}
		foreach ($sameday as $s) {
			$got_ids[]=$s["object_id"];
		}
	}

	$css = NULL;
	foreach ($got_ids as $id){
		$bg_str = sketchy_get_thumbnail_str($id, "sketchy-related");
		if (empty($bg_str)) {
			continue;
		}
		$picid = get_post_thumbnail_id($id);
		$maincolor = get_post_meta($picid, "apip_main_color", true);
		$addi_class = "nav-id-".$id;
		$css .= " .".$addi_class."{background: #fff url(\"".$bg_str." \") no-repeat center center ; background-size: 100%, auto; z-index:0; border-color: {$maincolor}; box-shadow: 0 0 8px {$maincolor};}";
	}

	if (""!=$css) {
		wp_add_inline_style('sketchy-style', $css);  
	}
}
add_action( 'wp_enqueue_scripts', 'sketchy_add_single_inline_css',2000 );
