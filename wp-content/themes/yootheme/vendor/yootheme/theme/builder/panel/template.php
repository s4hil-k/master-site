<?php

$id = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_content = [];
$attrs_image = [];
$attrs_grid = [];
$attrs_cell_image = [];
$attrs_image_container = [];
$attrs_link = [];
$attrs_icon = [];

// Image
if ($element['image']) {

    $src = $element['image'];

    $attrs_image['class'][] = 'el-image';
    $attrs_image['class'][] = $element['image_border'] ? "uk-border-{$element['image_border']}" : '';
    $attrs_image['class'][] = $element['image_box_shadow'] && !$element['panel_style'] ? "uk-box-shadow-{$element['image_box_shadow']}" : '';
    $attrs_image['class'][] = $element['link'] && $element['image_hover_box_shadow'] && !$element['panel_style'] && $element['link_style'] == 'panel' ? "uk-box-shadow-hover-{$element['image_hover_box_shadow']}" : '';
    $attrs_image['alt'] = $element['image_alt'];
    $attrs_image['uk-cover'] = ($element['panel_style'] && $element['image_card'] && in_array($element['image_align'], ['left', 'right'])) ? true : false;
    $attrs_image['uk-img'] = true;

    if ($this->isImage($element['image']) == 'gif') {
        $attrs_image['uk-gif'] = true;
    }

    if ($this->isImage($element['image']) == 'svg') {
        $attrs_image['uk-svg'] = $element['image_inline_svg'] ? true : false;
        $element['image'] = $this->image($src, array_merge($attrs_image, ['width' => $element['image_width'], 'height' => $element['image_height']]));

    } else {
        $element['image'] = $this->image([$src, 'thumbnail' => [$element['image_width'], $element['image_height']], 'srcset' => true], $attrs_image);
    }

    // Placeholder image if card and layout left or right
    if ($element['panel_style'] && $element['image_card'] && in_array($element['image_align'], ['left', 'right'])) {
        $attrs_image['class'][] = 'uk-invisible';
        $attrs_image['uk-cover'] = false;
        $element['image'] .= $this->image([$src, 'thumbnail' => [$element['image_width'], $element['image_height']], 'srcset' => true], $attrs_image);
    }

} elseif ($element['icon']) {

    $options = ["icon: {$element['icon']}"];
    $options[] = $element['icon_ratio'] ? "ratio: {$element['icon_ratio']}" : '';
    $attrs_icon['uk-icon'] = implode(';', array_filter($options));

    $attrs_icon['class'][] = 'el-image';
    $attrs_icon['class'][] = $element['icon_color'] ? "uk-text-{$element['icon_color']}" : '';

    $element['image'] = "<span {$this->attrs($attrs_icon)}></span>";
    $element['image_card'] = false;

}

// Card
if ($element['panel_style']) {

    $class[] = "uk-card uk-{$element['panel_style']}";
    $class[] = $element['panel_size'] ? "uk-card-{$element['panel_size']}" : '';
    $class[] = $element['link'] && $element['link_style'] == 'panel' && $element['panel_style'] != 'card-hover' ? 'uk-card-hover' : '';

    // Card media
    if ($element['image'] && $element['image_card'] && $element['image_align'] != 'between') {
        $attrs_content['class'][] = 'uk-card-body';
    } else {
        $class[] = 'uk-card-body';
    }

} else {
    $class[] = 'uk-panel';
}

// Image Align
$attrs_grid['class'][] = 'uk-child-width-expand';

if ($element['panel_style'] && $element['image_card']) {
    $attrs_grid['class'][] = 'uk-grid-collapse uk-grid-match';
} else {
    $attrs_grid['class'][] = $element['image_gutter'] ? "uk-grid-{$element['image_gutter']}" : '';
}

$attrs_grid['class'][] = $element['image_vertical_align'] ? 'uk-flex-middle' : '';
$attrs_grid['uk-grid'] = true;

if ($element['image_breakpoint']) {
    $attrs_cell_image['class'][] = "uk-width-{$element['image_grid_width']}@{$element['image_breakpoint']}";
    $attrs_cell_image['class'][] = $element['image_align'] == 'right' ? "uk-flex-last@{$element['image_breakpoint']}" : '';
} else {
    $attrs_cell_image['class'][] = "uk-width-{$element['image_grid_width']}";
    $attrs_cell_image['class'][] = $element['image_align'] == 'right' ? 'uk-flex-last' : '';
}

if ($element['panel_style'] && $element['image_card'] && in_array($element['image_align'], ['left', 'right'])) {
    $attrs_image_container['class'][] = 'uk-cover-container';
}

// Card media
if ($element['panel_style'] && $element['image'] && $element['image_card'] && $element['image_align'] != 'between' ) {
    $attrs_image_container['class'][] = "uk-card-media-{$element['image_align']}";
    $element['image'] = "<div{$this->attrs($attrs_image_container)}>{$element['image']}</div>";
}

// Link
if ($element['link']) {

    $attrs_link['href'] = $element['link'];
    $attrs_link['target'] = $element['link_target'] ? '_blank' : '';
    $attrs_link['uk-scroll'] = strpos($element['link'], '#') === 0;
    $attrs_link['class'][] = 'el-link';

    if ($element['link_style'] == 'panel') {

        if ($element['panel_style']) {
            $attrs_link['class'][] = 'uk-position-cover uk-position-z-index uk-margin-remove-adjacent';
        }

        if (!$element['panel_style'] && $element['image']) {
            $attrs_link['class'][] = $element['image_box_shadow_bottom'] ? 'uk-box-shadow-bottom' : '';
            $element['image'] = "<a{$this->attrs($attrs_link)}>{$element['image']}</a>";
        }

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

// Box-shadow bottom
if ((!$element['link'] || ($element['link'] && $element['link_style'] != 'panel')) && !$element['panel_style'] && $element['image_box_shadow_bottom']) {
    $element['image'] = "<div class=\"uk-box-shadow-bottom\">{$element['image']}</div>";
}

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php if ($element['link'] && $element['link_style'] == 'panel' && $element['panel_style']) : ?>
    <a<?= $this->attrs($attrs_link) ?>></a>
    <?php endif ?>

    <?php if ($element['image'] && in_array($element['image_align'], ['left', 'right'])) : ?>

        <div<?= $this->attrs($attrs_grid) ?>>
            <div<?= $this->attrs($attrs_cell_image) ?>>
                <?= $element['image'] ?>
            </div>
            <div>

                <?php if ($element['panel_style'] && $element['image']) : ?>
                    <div<?= $this->attrs($attrs_content) ?>>
                        <?= $this->render('@builder/panel/template-content', compact('attrs_link')) ?>
                    </div>
                <?php else : ?>
                    <?= $this->render('@builder/panel/template-content', compact('attrs_link')) ?>
                <?php endif ?>

            </div>
        </div>

    <?php else : ?>

        <?php if ($element['image_align'] == 'top') : ?>
        <?= $element['image'] ?>
        <?php endif ?>

        <?php if ($element['panel_style'] && $element['image'] && $element['image_card'] && in_array($element['image_align'], ['top', 'bottom'])) : ?>
            <div<?= $this->attrs($attrs_content) ?>>
                <?= $this->render('@builder/panel/template-content', compact('attrs_link')) ?>
            </div>
        <?php else : ?>
            <?= $this->render('@builder/panel/template-content', compact('attrs_link')) ?>
        <?php endif ?>

        <?php if ($element['image_align'] == 'bottom') : ?>
        <?= $element['image'] ?>
        <?php endif ?>

    <?php endif ?>

</div>
