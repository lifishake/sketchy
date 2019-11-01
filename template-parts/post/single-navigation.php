<?php
/**
 * 更多推荐
 * 需要apip支持
 */
    global $g_prev_post;
    global $g_next_post;
    global $g_related;
    global $g_sameday;

    echo '<nav class="navigation post-navigation" role="navigation"><h2 class="screen-reader-text">文章导航</h2><div class="single-nav">';
    $formated_str_link = '<div class="piced-link-window %4$s"><a href="%1$s" >%2$s</a><p class="nav-suffix">%3$s</p></div>';
    $formated_str_no_link = '<div class="piced-link-window %2$s"><span>没有了</span><p class="nav-suffix">%1$s</p></div>';
    $thumbnail_id = NULL;
    $bg_str = "";
    if (isset($_SESSION['last_tax'])&&!empty($_SESSION['last_tax'])) {
        echo '<div class="recorded-posts"><h2 class="related-post-title">'.$_SESSION["last_tax"].'</h2>';
    }
    if ( !empty($g_prev_post)) {
        $class_str = "nav-previous nav-id-".$g_prev_post->ID;
        printf($formated_str_link, get_permalink( $g_prev_post->ID ), apply_filters( 'the_title', $g_prev_post->post_title ), "&larr;前一篇", $class_str);
    } 
    else {
        printf($formated_str_no_link, "&larr;前一篇", "nav-previous nomore");
    }
    if ( !empty($g_next_post)) { 
        $class_str = "nav-next  nav-id-".$g_next_post->ID;
        printf($formated_str_link, get_permalink( $g_next_post->ID ), apply_filters( 'the_title', $g_next_post->post_title ), "后一篇&rarr;", $class_str);
    } 
    else {
        printf($formated_str_no_link, "后一篇&rarr;", "nav-next nomore");
    } 
    echo '</div></nav>';//single-nav
    if (empty($g_related)) {
        return;
    }

    $score = 4096;

    echo '<div class="related-posts"><h2 class="related-post-title">相关阅读</h2>';
    foreach ($g_related as $r) {
        $post_id = $r["object_id"];
        $post = get_post($post_id);
        printf( $formated_str_link,
            get_permalink( $post->ID ),
            apply_filters( 'the_title', $post->post_title ),
            sprintf("相关度:&nbsp;%s&#37;", floor(100*$r["evaluate"]/$score)),
            "nav-id-".$post->ID
        );
    }
    foreach ($g_sameday as $s) {
        $post_id = $s["object_id"];
        $post = get_post($post_id);
        printf( $formated_str_link,
            get_permalink( $post->ID ),
            apply_filters( 'the_title', $post->post_title ),
            sprintf("历史上的今天&nbsp;:%s", $s["year"]),
            "nav-id-".$post->ID
        );
    }
    echo '</div>';//related-posts
?>
