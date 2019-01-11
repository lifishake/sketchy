<?php
/**
 * 更多推荐
 * 需要apip支持
 */

$belt = '<div class = "sidebar-inline" >' ; 
if ( function_exists('apip_related_post') ) {
    $belt .= '<div class="widget-column belt-widgets-left">' ;
    $belt .= '<h2 class = "sidebar-inline-title">相关文章</h3>' ;
    $belt .= apip_related_post() ;
    $belt .= '</div>';
}
if ( function_exists('apip_sameday_post') && !wp_is_mobile() ) {
    $belt .= '<div class="widget-column belt-widgets-right">' ;
    $belt .= '<h2 class = "sidebar-inline-title">某年今日</h3>' ;
    $belt .= apip_sameday_post() ;
    $belt .= '</div>';
}
$belt.='</div>';
echo $belt;

?>
