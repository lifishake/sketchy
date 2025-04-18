<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage sketchy
 * @since 1.0
 */

 
/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

function sketchy_setup() {

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	add_image_size( 'sketchy-featured-image', 800, 480, true );
	add_image_size( 'sketchy-related', 500, 80, true );

	register_nav_menus( array(
		'top'    => 'Top Menu',
		'social' => 'Social Links Menu',
	) );

	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'caption',
        'search-form',
	) );

	add_theme_support( 'post-formats', array(
		'image',
	) );

	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'sketchy_setup' );

/**
 * 设定媒体宽度的全局变量。优先级为0，特别优先。
 *
 * @global int $content_width
 */
function sketchy_content_width() {
	$GLOBALS['content_width'] = 700 ;
}
add_action( 'after_setup_theme', 'sketchy_content_width', 0 );


function sketchy_widgets_init() {
	register_sidebar( array(
		'name'          => 'Footer 1',
		'id'            => 'sidebar-2',
		'description'   => '添加左侧页脚小工具',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Footer 2',
		'id'            => 'sidebar-3',
		'description'   => '添加右侧页脚小工具',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'sketchy_widgets_init' );

function sketchy_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'sketchy_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 */
function sketchy_scripts() {

	// Theme stylesheet.
	wp_enqueue_style( 'sketchy-style', get_stylesheet_uri(), array(),'20250419');

	wp_enqueue_script( 'sketchy-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$sketchy_l10n = array(
		'quote'          => sketchy_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'sketchy-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array(), '1.0', true );
		$sketchy_l10n['expand']         = '展开';
		$sketchy_l10n['collapse']       = '折叠';
		$sketchy_l10n['icon']           = sketchy_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
	}

	wp_enqueue_script( 'sketchy-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '20200408', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_localize_script( 'sketchy-skip-link-focus-fix', 'sketchyScreenReaderText', $sketchy_l10n );

	if ( is_singular() && comments_open() ) {
		if ( get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		wp_enqueue_script( 'sketchy-ajax-comment', get_theme_file_uri( '/assets/js/ajax-comment.js' ), array( 'jquery' ), '20200408', true );
		wp_localize_script( 'sketchy-ajax-comment', 'ajaxcomment', array( 'ajax_url'   => admin_url('admin-ajax.php')));
	}

	$css = '';
    $thumbnail_src = sketchy_get_thumbnail_str();
    $header_src = get_theme_file_uri( 'assets/images/header.jpg' );
	if ( !$thumbnail_src )
	$thumbnail_src = $header_src;
    $thumbnail_src = str_replace( get_bloginfo('url')."/wp_content", "../../", $thumbnail_src);

	$css .= ".comment-form-comment{background: #fff url(\"".$thumbnail_src." \") no-repeat center center ; background-size: 100%, auto;}";
	$css .= ".site-branding{
		background: url(\"".$thumbnail_src." \") no-repeat center right ;
		background-size: cover;
	}";
	if ( has_post_thumbnail() && is_singular() ) {
		$picid = get_post_thumbnail_id();
		$maincolor = get_post_meta($picid, "apip_main_color", true);
		if ( $maincolor ) {
			$newbg = sketchy_background_color($maincolor);
			$newmask = sketchy_mask_color($maincolor);
			$weathermask0 = sketchy_mask_color($maincolor, 0.4);
			$weathermask1 = sketchy_mask_color($maincolor, 0.1);
			//$css .= "body { background-color: ".$newbg."; }";
			//$css .= ".site-description { color: ".$maincolor."; }";
			//$css .= ".site-branding { border-color: ".$maincolor.";}";
			//$css .= ".navigation-top { border-color: ".$maincolor.";}";
			//$css .= "#comments { border-color: ".$maincolor.";}";
			$css .= ".comment-reply-link:hover { background-color: ".$newmask."; }";
			//$css .="li.bypostauthor > article > footer > div.comment-metadata > b.author-url, li.bypostauthor > article > footer > div.comment-metadata > b.author-url a { color: ".$maincolor."; }";
			//$css .= "span.mention{ color: ".$maincolor."; }";
			$css .= "ol.comment-list li:hover, ol.comment-list li:focus { border-color: ".$maincolor."; }";
			//$css .= ".site::before { background-image: linear-gradient(124deg, ".$weathermask0." 28%, ".$weathermask1." 63%, rgba(0,0,0,0));}";
			//$css .= ".site::after{ background-color: ".$newmask.";}";
			$css .= ".entry-content a:hover, .entry-content a:active, .entry-summary a:hover, .entry-summary a:active, .entry-footer a:hover, .entry-footer a:active, .author-url a:hover, .author-url a:active, .widget a:hover, .widget a:active, .site-footer .widget-area a:hover, .site-footer .widget-area a:active, .posts-navigation a:hover, .posts-navigation a:active, .site-info a:hover, .site-info a:active { color:${maincolor}; -webkit-box-shadow: inset 0 -1px 0 ${maincolor}; -box-shadow: inset 0 -1px 0 ${maincolor};}";
			$css .= ".comment-author a .ziface:hover, .comment-author a .ziface:focus {color:".$maincolor.";}";
			$css .= ".related-posts  a:focus , .related-posts  a:hover , .post-navigation a:focus ,	.post-navigation a:hover  { color: ".$maincolor."; }";
			$css .= ".piced-link-window:hover, .piced-link-window:focus{ border-color:".$maincolor."; }";
			$css .= ".social-navigation a:hover, .social-navigation a:focus {background-color:".$maincolor.";}";
			$css .= ".entry-footer .edit-link a.post-edit-link {background-color:".$maincolor.";}";
			
			if (is_single())
			{
				//$css .= ".single .site-main .post, .blog .site-main .post{ border-color: ".$maincolor.";}";
				$css .= ".sidebar-inline { border-color: ".$maincolor."; }";
			}
			else {
				//$css .= ".navigation-top .current_page_item > a {text-shadow: 1px 1px 8px ".$maincolor.";}";
			}			
		}
	}
	wp_add_inline_style('sketchy-style', $css);
}
add_action( 'wp_enqueue_scripts', 'sketchy_scripts' );

//配合apip动态修改chrome浏览器标签颜色
function sketchy_chrome_tab_color_change($input) {
	if ( has_post_thumbnail() && is_singular() ) {
		$picid = get_post_thumbnail_id();
		$maincolor = get_post_meta($picid, "apip_main_color", true);
		if ( $maincolor ) {
			return $maincolor;
		}
	}
	return $input;
}
add_filter( 'apip_tab_color', 'sketchy_chrome_tab_color_change' );

function sketchy_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'sketchy_content_image_sizes_attr', 10, 2 );

//https://stackoverflow.com/questions/31822842/adding-search-bar-to-the-nav-menu-in-wordpress
function sketchy_add_search_to_menu($items, $args) {
    // If this isn't the primary menu, do nothing
    if( !($args->theme_location == 'top') )
    return $items;
    // Otherwise, add search form
    return $items . '<li>' . get_search_form(false) . '</li>';
}
//add_filter('wp_nav_menu_items', 'sketchy_add_search_to_menu', 10, 2);

function sketchy_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'sketchy_header_image_tag', 10, 3 );

function sketchy_background_color($refcolor) {
	$rgbref = hex2rgb($refcolor);
	$hsvref = rgb2hsv($rgbref);
	$hsvref[1] = 3;
	$hsvref[2] = 90;
	$rgb = hsv2rgb($hsvref) ;
	$str = sprintf("#%1$02X%2$02X%3$02X",$rgb[0],$rgb[1],$rgb[2]) ;
	return $str;
}

function sketchy_mask_color($refcolor, $a=0.85) {
	$rgbref = hex2rgb($refcolor);
	$hsvref = rgb2hsv($rgbref);
	/*v95*/
	/*
	if (abs($rgbref[0] - $rgbref[1]) + abs( $rgbref[2] - $rgbref[0])+abs( $rgbref[1] - $rgbref[2]) <=30){
		$hsvref[0] = rand(0,359);
		$hsvref[1] = $hsvref[1]/3;
		$hsvref[2] = 93;
	}
	else {
		$hsvref[1] = 16;
		$hsvref[2] = 93;
	}
	$rgb = hsv2rgb($hsvref) ;
	$str = sprintf("#%1$02X%2$02X%3$02X",$rgb[0],$rgb[1],$rgb[2]) ;	
	*/
	if ($hsvref[2]>=95) {
		$a = $a - (0.05 * ($hsvref[2] - 94));
	}
	$str = sprintf("rgb(%d,%d,%d,%0.2f)",$rgbref[0],$rgbref[1],$rgbref[2],$a);
	return $str;
}

/**
 * 作用: 获得昵称的第一个汉字或者前两个英文字符
 * 来源: 自创
 */
function sketchy_get_ziface($nickyname) {

	if("关键字【彪】" == $nickyname) {
		return '<span class="ziface">彪</span>';
	}
	$ascii_len = strlen($nickyname);
	$mb_len = mb_strlen($nickyname, 'utf-8');
	
	if ($ascii_len == $mb_len) {
		//全英文，取第一个字母，转大写
		$zi=strtoupper(mb_substr($nickyname, 0, 1, 'utf-8'));
	} else {
		$n1 = str_replace(array("博客","故事","日志","记忆","的","先生","同学","小姐","大叔","小子","夫子","网友","生活",".","の","Mr","Mr.","Miss","先森","在","博士","公社","个人","游子","记录","路人","太郎","联盟","山人","之"), "", $nickyname);
		$first_str = mb_substr($n1, 0, 1, 'utf-8');
		if(in_array($first_str, array("大","小","老","后","阿"))) {
			$n1 = str_replace($first_str, "", $n1);
		}
		$last_str = mb_substr($n1, -1, NULL, 'utf-8');
		if(in_array($last_str, array("人","儿","子","生","哥","弟","妹","姐","爸","妈","叔","伯","爷","网","社","说","志","园","吧","记","客","团","徒"))) {
			$n1 = str_replace($last_str, "", $n1);
		}
		preg_match_all("/[\x{4e00}-\x{9fa5}]/u", $n1, $match);
		$chinese = $match[0];
		$len = count($chinese);
		switch ($len) {
			case 0:
				$zi=strtoupper(mb_substr($nickyname, 0, 1, 'utf-8'));
				break;
			case 1:	
			case 2:
			case 3:
				$zi=strtoupper($chinese[$len - 1]);
				break;
			case 4:
				$zi=strtoupper($chinese[$len - 2]);
				break;
			case 5:
			case 6:
				$zi=strtoupper($chinese[$len - 3]);
				break;
			default:
				$zi=strtoupper($chinese[$len - 1]);
				break;
		}
	}
	return '<span class="ziface">'.$zi.'</span>';
}

/**
 * 作用: HEX描述的颜色值转成RGBA描述(A作为另外的参数)
 * 来源: Oblique原版
 */
function hex2rgba_str($color, $opacity = 1.0) {

	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}
	$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	$rgb =  array_map('hexdec', $hex);
	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';

	return $output;
}

/**
* 作用: HEX描述的颜色值转成RGB
* 来源: Oblique原版
*/
if (!function_exists('hex2rgb'))
{
function hex2rgb($color) {
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}
	$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	$rgb =  array_map('hexdec', $hex);
	return $rgb;
}
}


/**
* 作用: RGB颜色值转成HSV描述
* 来源: http://stackoverflow.com/questions/1773698/rgb-to-hsv-in-php
* 输出的范围0-360, 0-100, 0-100!!
*/
if (!function_exists('rgb2hsv'))
{
function rgb2hsv(array $rgb)   
{                             
	list($R,$G,$B) = $rgb;
	$R = ($R / 255);
	$G = ($G / 255);
	$B = ($B / 255);

	$maxRGB = max($R, $G, $B);
	$minRGB = min($R, $G, $B);
	$chroma = $maxRGB - $minRGB;

	$computedV = floor(100 * $maxRGB);

	if ($chroma == 0)
		return array(0, 0, $computedV);

	$computedS = floor(100 * ($chroma / $maxRGB));

	if ($R == $minRGB)
		$h = 3 - (($G - $B) / $chroma);
	elseif ($B == $minRGB)
		$h = 1 - (($R - $G) / $chroma);
	else // $G == $minRGB
		$h = 5 - (($B - $R) / $chroma);

	$computedH = floor(60 * $h);

	return array($computedH, $computedS, $computedV);
}
}
/**
* 作用: RGB颜色值转成HSV描述
* 来源: 破袜子由C代码修改
* 输入的范围0-360, 0-100, 0-100!!
*/
if (!function_exists('hsv2rgb'))
{
function hsv2rgb(array $hsv) {
	list($H,$S,$V) = $hsv;
	//1
	$H /= 60;
	//2
	$I = floor($H);
	$F = $H - $I;
	$S /= 100;
	$V /= 100;
	//3
	$M = round( $V * (1 - $S) * 255);
	$N = round( $V * (1 - $S * $F) * 255 );
	$K = round( $V * (1 - $S * (1 - $F)) * 255 );
	$V = round( $V * 255) ;
	//4
	switch ($I) {
		case 0:
			list($R,$G,$B) = array($V,$K,$M);
			break;
		case 1:
			list($R,$G,$B) = array($N,$V,$M);
			break;
		case 2:
			list($R,$G,$B) = array($M,$V,$K);
			break;
		case 3:
			list($R,$G,$B) = array($M,$N,$V);
			break;
		case 4:
			list($R,$G,$B) = array($K,$M,$V);
			break;
		case 5:
		case 6: //for when $H=1 is given
			list($R,$G,$B) = array($V,$M,$N);
			break;
	}
	return array($R, $G, $B);
}
}

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );
/**
 * AJAX-comment
 */
require get_parent_theme_file_path( '/inc/ajax-comment.php' );

if (file_exists(dirname(__FILE__) . '/inc/pewae-private.php')){
    require get_parent_theme_file_path( '/inc/pewae-private.php' );
}
