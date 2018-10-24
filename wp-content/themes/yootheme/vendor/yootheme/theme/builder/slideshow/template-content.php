<?php

$attrs_title = [];
$attrs_content = [];
$attrs_meta = [];
$attrs_link = [];

// Title
$attrs_title['class'][] = 'el-title uk-margin';
$attrs_title['class'][] = $element['title_style'] ? "uk-{$element['title_style']}" : '';
$attrs_title['class'][] = $element['title_decoration'] ? "uk-heading-{$element['title_decoration']}" : '';
$attrs_title['class'][] = $element['title_color'] && $element['title_color'] != 'background' ? "uk-text-{$element['title_color']}" : '';

if ($element['overlay_animation'] == 'parallax') {
    $options = [];
    foreach(['x', 'y', 'scale', 'rotate', 'opacity'] as $prop) {
        $start = $element["title_parallax_{$prop}_start"];
        $end = $element["title_parallax_{$prop}_end"];
        $default = in_array($prop, ['scale', 'opacity']) ? 1 : 0;
        $middle = in_array($prop, ['scale', 'opacity']) ? 1 : 0;

        if (strlen($start) || strlen($end)) {
            $options[] = "{$prop}: " . (strlen($start) ? $start : $default) . ",{$middle}," . (strlen($end) ? $end : $default);
        }
    }
    $attrs_title['uk-slideshow-parallax'] = implode(';', array_filter($options));
}

// Meta
$attrs_meta['class'][] = 'el-meta uk-margin';

switch ($element['meta_style']) {
    case '':
        break;
    case 'meta':
    case 'muted':
        $attrs_meta['class'][] = "uk-text-{$element['meta_style']}";
        break;
    default:
        $attrs_meta['class'][] = "uk-{$element['meta_style']}";
}

if ($element['meta_align'] == 'top') {
    $attrs_meta['class'][] = 'uk-margin-remove-adjacent';
    $attrs_meta['class'][] = $element['meta_margin'] ? "uk-margin-{$element['meta_margin']}-bottom" : '';
}

if ($item['meta'] && $element['meta_align'] == 'bottom') {
    $attrs_title['class'][] = 'uk-margin-remove-adjacent';
    $attrs_title['class'][] = $element['meta_margin'] ? "uk-margin-{$element['meta_margin']}-bottom" : '';
}

if ($element['overlay_animation'] == 'parallax') {
    $options = [];
    foreach(['x', 'y', 'scale', 'rotate', 'opacity'] as $prop) {
        $start = $element["meta_parallax_{$prop}_start"];
        $end = $element["meta_parallax_{$prop}_end"];
        $default = in_array($prop, ['scale', 'opacity']) ? 1 : 0;
        $middle = in_array($prop, ['scale', 'opacity']) ? 1 : 0;

        if (strlen($start) || strlen($end)) {
            $options[] = "{$prop}: " . (strlen($start) ? $start : $default) . ",{$middle}," . (strlen($end) ? $end : $default);
        }
    }
    $attrs_meta['uk-slideshow-parallax'] = implode(';', array_filter($options));
}

// Content
$attrs_content['class'][] = 'el-content uk-margin';
$attrs_content['class'][] = $element['content_style'] ? "uk-text-{$element['content_style']}" : '';

if ($element['overlay_animation'] == 'parallax') {
    $options = [];
    foreach(['x', 'y', 'scale', 'rotate', 'opacity'] as $prop) {
        $start = $element["content_parallax_{$prop}_start"];
        $end = $element["content_parallax_{$prop}_end"];
        $default = in_array($prop, ['scale', 'opacity']) ? 1 : 0;
        $middle = in_array($prop, ['scale', 'opacity']) ? 1 : 0;

        if (strlen($start) || strlen($end)) {
            $options[] = "{$prop}: " . (strlen($start) ? $start : $default) . ",{$middle}," . (strlen($end) ? $end : $default);
        }
    }
    $attrs_content['uk-slideshow-parallax'] = implode(';', array_filter($options));
}

// Link
if ($item['link']) {

    $attrs_link['href'] = $item['link'];
    $attrs_link['target'] = $element['link_target'] ? '_blank' : '';
    $attrs_link['uk-scroll'] = strpos($item['link'], '#') === 0;
    $attrs_link['class'][] = 'el-link';

    switch ($element['link_style']) {
        case '':
            break;
        case 'link-muted':
        case 'link-text':
            $attrs_link['class'][] = "uk-{$element['link_style']}";
            break;
        default:
            $attrs_link['class'][] = "uk-button uk-button-{$element['link_style']}";
            $attrs_link['class'][] = $element['link_size'] ? "uk-button-{$element['link_size']}" : '';
    }

    if ($element['overlay_animation'] == 'parallax') {
        $options = [];
        foreach(['x', 'y', 'scale', 'rotate', 'opacity'] as $prop) {
            $start = $element["link_parallax_{$prop}_start"];
            $end = $element["link_parallax_{$prop}_end"];
            $default = in_array($prop, ['scale', 'opacity']) ? 1 : 0;
            $middle = in_array($prop, ['scale', 'opacity']) ? 1 : 0;

            if (strlen($start) || strlen($end)) {
                $options[] = "{$prop}: " . (strlen($start) ? $start : $default) . ",{$middle}," . (strlen($end) ? $end : $default);
            }
        }
        $attrs_link['uk-slideshow-parallax'] = implode(';', array_filter($options));
    }

}

?>

<?php if ($item['meta'] && $element['meta_align'] == 'top') : ?>
<div<?= $this->attrs($attrs_meta) ?>><?= $item['meta'] ?></div>
<?php endif ?>

<?php if ($item['title']) : ?>
<<?= $element['title_element'] . $this->attrs($attrs_title) ?>>
    <?php if ($element['title_color'] == 'background') : ?>
    <span class="uk-text-background"><?= $item['title'] ?></span>
    <?php elseif ($element['title_decoration'] == 'line') : ?>
    <span><?= $item['title'] ?></span>
    <?php else : ?>
    <?= $item['title'] ?>
    <?php endif ?>
</<?= $element['title_element'] ?>>
<?php endif ?>

<?php if ($item['meta'] && $element['meta_align'] == 'bottom') : ?>
<div<?= $this->attrs($attrs_meta) ?>><?= $item['meta'] ?></div>
<?php endif ?>

<?php if ($item['content']) : ?>
<div<?= $this->attrs($attrs_content) ?>><?= $item['content'] ?></div>
<?php endif ?>

<?php if ($item['link'] && ($item['link_text'] || $element['link_text'])) : ?>
<p><a<?= $this->attrs($attrs_link) ?>><?= $item['link_text'] ? $item['link_text'] : $element['link_text'] ?></a></p>
<?php endif ?>
