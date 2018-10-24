<?php
global $post;


$sticky ="";
$stickyAttrs="";

$second_level = $element["second_level"];

if($element["sticky"])
{
    $sticky .= "uk-sticky";
    $stickyAttrs .= "offset:".$element['offset'].";";
    if($element['bottom']){
        $stickyAttrs .= "bottom:" . $element['bottom'] . ";";
    } else{
        $stickyAttrs .= "bottom:true;";
    }
    $stickyAttrs .= "media:".$element['breakpoint'].";";

    if($element['animation']){
        $stickyAttrs .= "animation:". $element['animation'] .";";
    }
}


if (is_page() && $post->post_parent)
    if($second_level) {
        $childpages = wp_list_pages('sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0');
    } else{
        $childpages = wp_list_pages('sort_column=menu_order&depth=1&title_li=&child_of=' . $post->post_parent . '&echo=0');
    }
else
    if($second_level) {
        $childpages = wp_list_pages('sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0');
    } else{
        $childpages = wp_list_pages('sort_column=menu_order&depth=1&title_li=&child_of=' . $post->ID . '&echo=0');
    }

?>


<aside<?php if($element["sticky"]): echo " $sticky = \"$stickyAttrs\""; endif;?> >
<nav class="uk-panel widget-menu">
    <a href="<?= get_permalink($post->post_parent); ?>"><h3><?= get_the_title($post->post_parent); ?></h3></a>
    <ul class="uk-nav uk-nav-default uk-nav-parent-icon uk-nav-accordion">
        <?= $childpages; ?>
    </ul>
</nav>
</aside>