<?php

$attrs_nav = [];

// Switcher
$options = ["connect: #{$connect_id}"];
$options[] = $element['switcher_animation'] ? "animation: uk-animation-{$element['switcher_animation']}" : '';

if ($element['switcher_breakpoint'] && in_array($element['switcher_position'], ['left', 'right'])) {

    if ($element['switcher_style'] == 'tab') {
        $options[] = "media: @{$element['switcher_breakpoint']}";
    }

}

if ($element['switcher_style'] == "tab") {
    $attrs_nav['uk-tab'] = implode(';', array_filter($options));
} else {
    $attrs_nav['uk-switcher'] = implode(';', array_filter($options));
}

// Margin
if (in_array($element['switcher_position'], ['top', 'bottom'])) {
    switch ($element['switcher_margin']) {
        case '':
            $attrs_nav['class'][] = 'uk-margin';
            break;
        default:
            $attrs_nav['class'][] = "uk-margin-{$element['switcher_margin']}";
    }
}

// Style Horizontal
switch ($element['switcher_style']) {
    case 'subnav':
        $nav_horizontal = "uk-{$element['switcher_style']}";
        break;
    case 'subnav-pill':
    case 'subnav-divider':
        $nav_horizontal = "uk-subnav uk-{$element['switcher_style']}";
        break;
    case 'tab':
        $nav_horizontal = $element['switcher_position'] == 'bottom' ? "uk-tab-{$element['switcher_position']}" : '';
        break;
    case 'thumbnav':
        $nav_horizontal = '';
        $attrs_nav['class'][] = 'uk-thumbnav';

        if ($element['switcher_thumbnail_nowrap']) {
            $attrs_nav['class'][] = 'uk-flex-nowrap';
        } else {
            $attrs_nav['uk-margin'] = true;
        }

        break;
}

// Alignment
switch ($element['switcher_align']) {
    case 'right':
    case 'center':
        $nav_horizontal .= " uk-flex-{$element['switcher_align']}";
        break;
    case 'justify':
        $nav_horizontal .= ' uk-child-width-expand';
        break;
}

// Style Vertical
switch ($element['switcher_style']) {
    case 'subnav':
    case 'subnav-pill':
    case 'subnav-divider':
        $nav_vertical  = $element['switcher_style_primary'] ? 'uk-nav uk-nav-primary' : 'uk-nav uk-nav-default';
        $nav_vertical .= $element['text_align'] ? ' uk-text-left' : '';
        break;
    case 'tab':
        $nav_vertical = "uk-tab-{$element['switcher_position']}";
        break;
    case 'thumbnav':
        $nav_vertical = 'uk-thumbnav-vertical';
        break;
}

if (in_array($element['switcher_position'], ['top', 'bottom'])) {
    $attrs_nav['class'][] = $nav_horizontal;
} else {
    $attrs_nav['class'][] = $nav_vertical;

    if ($element['switcher_style'] != 'tab') {
        $attrs_nav['uk-toggle'] =  "cls: {$nav_vertical} {$nav_horizontal}; mode: media; media: @{$element['switcher_breakpoint']}";
    }
}

$attrs_nav['class'][] = 'el-nav';
$attrs_nav['class'] = array_unique($attrs_nav['class']);

?>

<ul<?= $this->attrs($attrs_nav) ?>>
    <?php foreach ($element as $item) :

        // Display
        if (!$element['show_title']) { $item['title'] = ''; }
        if (!$element['show_meta']) { $item['meta'] = ''; }
        if (!$element['show_content']) { $item['content'] = ''; }
        if (!$element['show_image']) { $item['image'] = ''; }
        if (!$element['show_link']) { $item['link'] = ''; }
        if (!$element['show_label']) { $item['label'] = ''; }
        if (!$element['show_thumbnail']) { $item['thumbnail'] = ''; }

        // Image
        $thumbnail = '';
        $src = $item['thumbnail'] ? $item['thumbnail'] : $item['image'];

        if ($element['switcher_style'] == 'thumbnav' && $src) {

            $attrs_thumbnail['alt'] = $item['label'] ? $item['label'] : $item['title'];
            $attrs_thumbnail['uk-img'] = true;

            if ($this->isImage($src) == 'svg') {
                $thumbnail = $this->image($src, array_merge($attrs_thumbnail, ['width' => $element['switcher_thumbnail_width'], 'height' => $element['switcher_thumbnail_height']]));
            } else {
                $thumbnail = $this->image([$src, 'thumbnail' => [$element['switcher_thumbnail_width'], $element['switcher_thumbnail_height']], 'srcset' => true], $attrs_thumbnail);
            }

        }

    ?>
    <li>
        <a href="#"><?= $thumbnail ? $thumbnail : ($item['label'] ? $item['label'] : $item['title']) ?></a>
    </li>
    <?php endforeach ?>
</ul>
