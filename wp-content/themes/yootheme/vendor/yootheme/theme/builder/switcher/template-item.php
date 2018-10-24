<?php

$attrs_image = [];
$attrs_grid = [];
$attrs_cell_image = [];

// Display
if (!$element['show_title']) { $item['title'] = ''; }
if (!$element['show_meta']) { $item['meta'] = ''; }
if (!$element['show_content']) { $item['content'] = ''; }
if (!$element['show_image']) { $item['image'] = ''; }
if (!$element['show_link']) { $item['link'] = ''; }
if (!$element['show_label']) { $item['label'] = ''; }
if (!$element['show_thumbnail']) { $item['thumbnail'] = ''; }

$image = '';

// Image
if ($item['image']) {

    $attrs_image['class'][] = 'el-image';
    $attrs_image['class'][] = $element['image_border'] ? "uk-border-{$element['image_border']}" : '';
    $attrs_image['class'][] = $element['image_box_shadow'] ? "uk-box-shadow-{$element['image_box_shadow']}" : '';
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

// Box-shadow bottom
if ($element['image_box_shadow_bottom']) {
    $image = "<div class=\"uk-box-shadow-bottom\">{$image}</div>";
}

// Image Align
$attrs_grid['class'][] = 'uk-child-width-expand';
$attrs_grid['class'][] = $element['image_gutter'] ? "uk-grid-{$element['image_gutter']}" : '';
$attrs_grid['class'][] = $element['image_vertical_align'] ? 'uk-flex-middle' : '';
$attrs_grid['uk-grid'] = true;

$attrs_cell_image['class'][] = "uk-width-{$element['image_grid_width']}@{$element['image_breakpoint']}";
$attrs_cell_image['class'][] = $element['image_align'] == 'right' ? "uk-flex-last@{$element['image_breakpoint']}" : '';

?>

<?php if ($image && in_array($element['image_align'], ['left', 'right'])) : ?>

    <div<?= $this->attrs($attrs_grid) ?>>
        <div<?= $this->attrs($attrs_cell_image) ?>>
            <?= $image ?>
        </div>
        <div>
            <?= $this->render('@builder/switcher/template-content', compact('item')) ?>
        </div>
    </div>

<?php else : ?>

    <?php if ($element['image_align'] == 'top') : ?>
    <?= $image ?>
    <?php endif ?>

    <?= $this->render('@builder/switcher/template-content', compact('item')) ?>

    <?php if ($element['image_align'] == 'bottom') : ?>
    <?= $image ?>
    <?php endif ?>

<?php endif ?>
