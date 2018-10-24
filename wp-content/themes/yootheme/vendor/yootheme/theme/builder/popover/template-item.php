<?php

$attrs_item = [];
$attrs_content = [];
$attrs_image = [];
$attrs_link = [];

$image = '';

// Display
if (!$element['show_title']) { $item['title'] = ''; }
if (!$element['show_meta']) { $item['meta'] = ''; }
if (!$element['show_content']) { $item['content'] = ''; }
if (!$element['show_image']) { $item['image'] = ''; }
if (!$element['show_link']) { $item['link'] = ''; }

// Item
$attrs_item['class'][] = 'el-item';
$attrs_item['class'][] = "uk-card uk-card-{$element['card_style']}";
$attrs_item['class'][] = $element['card_size'] ? "uk-card-{$element['card_size']}" : '';
$attrs_item['class'][] = $item['link'] && $element['link_style'] == 'card' ? 'uk-card-hover' : '';

// Card media
if ($item['image'] && $element['image_card']) {
    $attrs_content['class'][] = 'uk-card-body';
} else {
    $attrs_item['class'][] = 'uk-card-body';
}

// Image
if ($item['image']) {

    $attrs_image['class'][] = 'el-image uk-display-block uk-margin-auto';
    $attrs_image['class'][] = $element['image_border'] && !$element['image_card'] ? "uk-border-{$element['image_border']}" : '';
    $attrs_image['alt'] = $item['image_alt'];
    $attrs_image['uk-img'] = true;

    if ($this->isImage($item['image']) == 'gif') {
        $attrs_image['uk-gif'] = true;
    }

    if ($this->isImage($item['image']) == 'svg') {
        $image = $this->image($item['image'], array_merge($attrs_image, ['width' => $element['image_width'], 'height' => $element['image_height']]));
    } else {
        $image = $this->image([$item['image'], 'thumbnail' => [$element['image_width'], $element['image_height']], 'srcset' => true], $attrs_image);
    }

}

// Link
if ($item['link']) {

    $attrs_link['href'] = $item['link'];
    $attrs_link['target'] = $element['link_target'] ? '_blank' : '';
    $attrs_link['uk-scroll'] = strpos($item['link'], '#') === 0;
    $attrs_link['class'][] = 'el-link';

    if ($element['link_style'] == 'card') {

        $attrs_link['class'][] = 'uk-position-cover uk-margin-remove-adjacent';

    } else {

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

    }

}

?>

<div<?= $this->attrs($attrs_item) ?>>

    <?php if ($item['link'] && $element['link_style'] == 'card') : ?>
    <a<?= $this->attrs($attrs_link) ?>></a>
    <?php endif ?>

    <?= $image ?>

    <?php if ($item['image'] && $element['image_card']) : ?>
        <div<?= $this->attrs($attrs_content) ?>>
            <?= $this->render('@builder/popover/template-content', compact('item', 'attrs_link')) ?>
        </div>
    <?php else : ?>
        <?= $this->render('@builder/popover/template-content', compact('item', 'attrs_link')) ?>
    <?php endif ?>

</div>
