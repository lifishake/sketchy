<?php
/**
 * 自定义模板功能
 *
 * @package WordPress
 * @subpackage SkyWarp2
 * @since 1.0
 */

/**
 * 作用: archive标题
 * 来源: 破袜子原创
 */
function sketchy_archive_title() {
  /*为了中文化,放弃wordpress自带的the_archive_title()*/
  $format = '%1$s%2$s: %3$s%4$s';
  $before = '<h1 class="page-title">';
  $after = '</h1>';
  $part1='';
  $part2='';
  if ( is_category() ) {
  $part1 = '分类';
  $part2 = single_cat_title( '', false );
  }
  else if ( is_tag() ) {
  $part1 = '标签';
  $part2 = single_tag_title( '', false );
  }
  else if ( is_year() ) {
  $part1 = '年';
  $part2 =  get_the_date('Y') ;
  }
  else if ( is_month() ) {
  $part1 = '月';
  $part2 = get_the_date('m/Y');
  }
  else if ( is_day() ) {
  $part1 = '日';
  $part2 = get_the_date(get_option('date_format'));
  }
  else{
  $part1 = '归档';
  }
  $out = sprintf($format, $before, $part1, $part2, $after);
  echo $out ;
}

/**
 * 作用: 取得category路径
 * 来源: 破袜子原创
 */
function sketchy_get_categories_trace(){
  if ( !is_single() && !is_category() ||is_attachment() )
  {
  return '';
  }
  if ( is_single() && !is_attachment( ))
  {
  $category = get_the_category();
  $catID = $category[0]->cat_ID;
  }
  else if ( is_category() )
  {
    $cat = get_category( get_query_var( 'cat' ) );
    $catID = $cat->cat_ID;
  }
  else
  {
  return '';
  }
  $return = get_category_parents($catID, true, ' &raquo; ', false);
  $pos = strrpos($return,"&raquo;");
  if ( $pos !== false ) {
  $return = substr_replace($return, "", -8,8);
  }
  return $return;
}

/**
 * 作用: 显示category面包屑(屏幕输出)
 * 来源: 破袜子原创
 */
function sketchy_breadcrumb_category(){
  if ( !is_category() ){
  return ;
  }
  $home = '<a href="'.home_url().'" >主页</a>';
  $categories = sketchy_get_categories_trace();
  echo '<div class="taxonomy-description"><span class="header-breadcrumb">'.$home.' &raquo; '.$categories.'</span></div>';
}

/**
 * 作用: 取得日期追踪。因为一日多篇的情况比较少见，所以取到月。
 * 来源: 破袜子原创
 */
function sketchy_get_dates_trace(){
  if ( !is_single() && !is_date() ||is_attachment() )
  {
  return '';
  }
  $archive_year  = get_the_time('Y');
  $archive_month = get_the_time('m');
  $return = sprintf('<a href="%1$s">%2$s</a>年<a href="%3$s">%4$s</a>月', get_year_link($archive_year), $archive_year, get_month_link($archive_year, $archive_month), $archive_month );
  return $return;
}

/**
 * 作用: 显示日期面包屑。(屏幕输出)
 * 来源: 破袜子原创
 */
function sketchy_breadcrumb_date(){
  if ( !is_date() ){
  return ;
  }
  $home = '<a href="'.home_url().'" >主页</a>';
  $date = sketchy_get_dates_trace();
  echo '<div class="taxonomy-description"><span class="header-breadcrumb">'.$home.' &raquo; '.$date.'</span></div>';
}

/**
 * 作用: 显示面包屑。目前支持category和date。
 * 返回值: string
 * 来源: 破袜子原创
 */
function sketchy_breadcrumb(){
  if ( is_date() ){
  sketchy_breadcrumb_date();
  }
  elseif ( is_category() ){
  sketchy_breadcrumb_category();
  }
  else{
  return;
  }
}

/**
 * 作用: 进行时间比较。
 * 参数: $from string 开始时间
 * 参数: $to string 结束时间
 * 参数: $before string 前修饰文字
 * 参数: $after string 后修饰文字
 * 返回值: string
 * 来源: 破袜子原创
 */
function sketchy_timediff( $from, $to, $before, $after) {
  if ( empty($from) || empty($to) )
  return '';
  if( empty($before) )
  $before = '于';
  if( empty($after) )
  $after = '前';
  $from_int = strtotime($from) ;
  $to_int = strtotime($to) ;
  $diff_time = abs($to_int - $from_int) ;
  if ( $diff_time > 60 * 60 * 24 * 365 ){//年
  $num = round($diff_time / (60 * 60 * 24 * 365));
  $uni = '年';
  }
  else if ( $diff_time > 60 * 60 * 24 * 31 ) {//月
  $num = round($diff_time / (60 * 60 * 24 * 30));
  $uni = '个月';
  }
  else if ( $diff_time > 60 * 60 * 24 ) {//天
  $num = round($diff_time / (60 * 60 * 24));
  $uni = '天';
  }
  else if ( $diff_time > 60 * 60 ) { //小时
  $num = round($diff_time / 3600);
  $uni = '小时';
  }
  else { //分钟
  $num = round($diff_time / 60);
  $uni = '分';
  }
  $return = $before.$num.$uni.$after ;
  return $return;
}

/**
 * 作用: 取得文章发表的相对时间。
 * 返回值: string
 * 来源: 破袜子原创
 */
function sketchy_rel_post_date() {
  global $post;
  $post_date_time = mysql2date('j-n-Y H:i:s', $post->post_date, false);
  $current_time = current_time('timestamp');
  $date_today_time = gmdate('j-n-Y H:i:s', $current_time);
  return sketchy_timediff( $post_date_time, $date_today_time ,'&nbsp;','前' ) ;
}

/**
 * 作用: 取得评论发表的相对时间。
 * 返回值: string
 * 来源: 破袜子原创
 */
function sketchy_rel_comment_date() {
  global $post , $comment;
  $post_date_time = mysql2date('j-n-Y H:i:s', $post->post_date, false);
  $comment_date_time = mysql2date('j-n-Y H:i:s', $comment->comment_date, false);
  return sketchy_timediff( $post_date_time, $comment_date_time ,'&nbsp;','后' ) ;
}

/**
 * 作用: 取得时间文字。
 * 返回值: string
 * 来源: 破袜子原创
 */
function sketchy_time_link() {
  $time_string = '<span class="calendar-desc">%1$s<time class="entry-date published updated" datetime="%2$s">%3$s</time></span>';

  $time_string = sprintf( $time_string,
  sketchy_get_svg( array( 'icon' => 'calendar' ) ),
  get_the_date( DATE_W3C ),
  sketchy_rel_post_date()
  );

  return $time_string;
}

/**
 * 作用: 显示文章头信息。(屏幕输出)
 * 来源: 破袜子原创
 */
function sketchy_entry_meta(){
  $has_edit_link = false;
  $all_meta = '';
  $has_date = true;
  $has_category = true;
  $has_tag = false;
  if ( is_category() ) {
    $has_category = false;
  }
  if ( is_tag() ) {
    $has_tag = false;
  }
  if ( is_date() ) {
    $has_date = false;
  }
  if ( is_single() ) {
    $has_category = false;
    $has_tag = false;
    $has_edit_link = false;
  }
  if ( is_page() ) {
    $has_date = false;
    $has_category = false;
    $has_tag = false;
    $has_edit_link = false;
  }
  if ( $has_date ) {
    $all_meta .= sketchy_time_link();
  }
  if ( $has_tag ) {
    $tags_list = get_the_tag_list( '', ', ' );
    if ( $tags_list ) {
        $all_meta.= '<span class="tag-desc">' . sketchy_get_svg( array( 'icon' => 'hashtag' ) ) . $tags_list . '</span>';
      }
  }
  echo $all_meta;
  if ( $has_edit_link ) {
    sketchy_edit_link();
  }
}

function sketchy_the_title()
{

}

/**
 * 作用: 显示文章脚信息。(屏幕输出)
 * 来源: 破袜子原创
 */
function sketchy_entry_footer() {

  $tags_list = get_the_tag_list( '', ', ' );

  if ( $tags_list || get_edit_post_link() ) {

  echo '<footer class="entry-footer">';
  if ( 'post' === get_post_type() ) {
  if ( is_single() && (!(has_tag('zhuanzai') || has_category('zhaichaohedaolian'))) ) {
  get_template_part( 'meta', 'license' );
  }
  echo '<span class="cat-tags-links">';
  //日期
  echo '<span class="date-links">' . sketchy_get_svg( array( 'icon' => 'calendar' ) ) . sketchy_get_dates_trace() . '</span>';
  //类别
  echo '<span class="cat-links">' . sketchy_get_svg( array( 'icon' => 'folder-open' ) ) . sketchy_get_categories_trace() . '</span>';
  //标签
  if ( $tags_list ) {
  echo '<span class="tags-links">' . sketchy_get_svg( array( 'icon' => 'hashtag' ) ) . $tags_list . '</span>';
  }
  //发帖时天气
  if( function_exists('apip_get_heweather') )  {
      $heweather = apip_get_heweather();
      if ( '' !== $heweather ) {
          echo '<span class="weather-links">'.$heweather. '</span>';
      }
  }

  echo '</span>';
  }

  sketchy_edit_link();

  echo '</footer> <!-- .entry-footer -->';
  }
}

/**
 * 作用: 显示编辑链接。(屏幕输出)
 * 来源: 破袜子原创
 */
function sketchy_edit_link() {

  $link = edit_post_link(
  '编辑',
  '<span class="edit-link">',
  '</span>'
  );

  return $link;
}


function sketchy_utf8_trim($str) {

    $len = strlen($str);

    for ($i=strlen($str)-1; $i>=0; $i-=1){
        $hex .= ' '.ord($str[$i]);
        $ch = ord($str[$i]);
        if (($ch & 128)==0) return(substr($str,0,$i));
        if (($ch & 192)==192) return(substr($str,0,$i));
    }
    return($str.$hex);
}

function the_sketchy_excerpt(){
  if ( !is_search() ) {
  the_excerpt();
  return;
  }
  $keyword = get_search_query();
  $text = get_the_content();
  $text = strip_shortcodes($text);
    $text = str_replace( ']]>', ']]&gt;', $text );
    $text = strip_tags( $text );
    $pos = mb_stripos( $text, $keyword,0,'utf-8' );
    if ( $pos > 12 ){
    	$return = mb_substr($text,$pos-10,50,'utf-8').'...';
    }
    else {
    	$return = mb_substr($text,0,50,'utf-8').'...'
;
    }
    $return = mb_ereg_replace($keyword, '<span class="highlight">'.$keyword.'</span>', $return);
    echo $return;
}
