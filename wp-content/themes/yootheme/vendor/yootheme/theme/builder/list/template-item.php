<?php

$attrs_grid = [];
$attrs_cell = [];
$attrs_content = [];
$attrs_link = [];

// Display
if (!$element['show_image']) {
    $item['image'] = '';
    $item['icon'] = '';
}
if (!$element['show_link']) { $item['link'] = ''; }

// Image Align
$attrs_grid['class'][] = 'uk-grid-small uk-child-width-expand uk-flex-nowrap uk-flex-middle';
$attrs_grid['uk-grid'] = true;
$attrs_cell['class'][] = 'uk-width-auto';
$attrs_cell['class'][] = $element['image_align'] == 'right' ? 'uk-flex-last' : '';

// Image
if ($item['image']) {

    $attrs_image = [];

    $attrs_image['class'][] = 'el-image';
    $attrs_image['class'][] = $element['image_border'] ? "uk-border-{$element['image_border']}" : '';
    $attrs_image['alt'] = $item['image_alt'];
    $attrs_image['uk-img'] = true;

    if ($this->isImage($item['image']) == 'gif') {
        $attrs_image['uk-gif'] = true;
    }

    if ($this->isImage($item['image']) == 'svg') {
        $attrs_image['uk-svg'] = $element['image_inline_svg'] ? true : false;
        $item['image'] = $this->image($item['image'], array_merge($attrs_image, ['width' => $element['image_width'], 'height' => $element['image_height']]));
    } else {
        $item['image'] = $this->image([$item['image'], 'thumbnail' => [$element['image_width'], $element['image_height']], 'srcset' => true], $attrs_image);
    }

} elseif ($item['icon']) {

    $attrs_icon = [];

    $options = ["icon: {$item['icon']}"];
    $options[] = $element['icon_ratio'] ? "ratio: {$element['icon_ratio']}" : '';
    $attrs_icon['uk-icon'] = implode(';', array_filter($options));

    $attrs_icon['class'][] = 'el-image';
    $attrs_icon['class'][] = $item['icon_color'] ? "uk-text-{$item['icon_color']}" : '';

    $item['image'] = "<span {$this->attrs($attrs_icon)}></span>";
}

// Content
$attrs_content['class'][] = 'el-content';

switch ($element['content_style']) {
    case '':
        break;
    case 'bold':
    case 'muted':
        $attrs_content['class'][] = "uk-text-{$element['content_style']}";
        break;
    default:
        $attrs_content['class'][] = "uk-{$element['content_style']}";
}

// Link
if ($item['link']) {

    $attrs_link['target'] = $item['link_target'] ? '_blank' : '';
    $attrs_link['uk-scroll'] = strpos($item['link'], '#') === 0;
    $attrs_link['class'][] = 'el-link';
    $attrs_link['class'][] = $element['link_style'] ? "uk-link-{$element['link_style']}" : '';

    $item['content'] = $this->link($item, $item['link'], $attrs_link);

    if ($item['image']) {
        $item['image'] = $this->link($item['image'], $item['link'], ['class' => 'uk-link-reset']);
    }
}

?>

<?php if ($item['image']) : ?>
    <div<?= $this->attrs($attrs_grid) ?>>
        <div<?= $this->attrs($attrs_cell) ?>>
            <?= $item['image'] ?>
        </div>
        <div>
            <div<?= $this->attrs($attrs_content) ?>>
                <?= $item['content'] ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <div<?= $this->attrs($attrs_content) ?>>
        <?= $item['content'] ?>
    </div>
<?php endif ?>
