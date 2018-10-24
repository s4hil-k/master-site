<?php

$id = $element['id'];
$class = [];
$attrs_tile = [];
$attrs_tile_container = [];
$attrs_image = [];
$attrs_overlay = [];
$attrs_container = [];

// Width
$index = $element->index;
$widths = $element['widths'] ?: array_map(function ($widths) use ($index) {
    // Deprecated
    return explode(',', $widths)[$index];
}, explode('|', $element->parent['layout']));
$breakpoints = ['s', 'm', 'l', 'xl'];
$breakpoint = $element->parent['breakpoint'];

// Above Breakpoint
$width = $widths[0] ?: 'expand';
$width = $width === 'fixed' ? $element->parent['fixed_width'] : $width;
$class[] = "uk-width-{$width}".($breakpoint ? "@{$breakpoint}" : '');

// Intermediate Breakpoint
if (isset($widths[1]) && $pos = array_search($breakpoint, $breakpoints)) {
    $breakpoint = $breakpoints[$pos-1];
    $width = $widths[1] ?: 'expand';
    $class[] = "uk-width-{$width}".($breakpoint ? "@{$breakpoint}" : '');
}

// Order
if (!isset($element->parent->children[$index + 1]) && $element->parent['order_last']) {
    $class[] = "uk-flex-first@{$breakpoint}";
}

// Visibility
$visibilities = ['xs', 's', 'm', 'l', 'xl'];
$visible = $element->count() ? 4 : false;

foreach ($element as $el) {
    $visible = min(array_search($el['visibility'], $visibilities), $visible);
}

if ($visible) {
    $element['visibility'] = $visibilities[$visible];
    $class[] = "uk-visible@{$visibilities[$visible]}";
}

/*
 * Column options
 */

// Tile
if ($element['style'] || $element['image']) {

    $class[] = 'uk-grid-item-match';
    $attrs_tile_container['class'][] = $element['style'] ? "uk-tile-{$element['style']}" : '';
    $attrs_tile['class'][] = 'uk-tile';

    // Padding
    switch ($element['padding']) {
        case '':
            break;
        case 'none':
            $attrs_tile['class'][] = 'uk-padding-remove';
            break;
        default:
            $attrs_tile['class'][] = "uk-tile-{$element['padding']}";
    }

    // Image
    if ($element['image']) {

        $attrs_image = $this->bgImage($element['image'], [
            'width' => $element['image_width'],
            'height' => $element['image_height'],
            'size' => $element['image_size'],
            'position' => $element['image_position'],
            'visibility' => $element['image_visibility'],
            'blend_mode' => $element['media_blend_mode'],
            'background' => $element['media_background'],
            'effect' => $element['image_effect'],
            'parallax_bgx_start' => $element['image_parallax_bgx_start'],
            'parallax_bgy_start' => $element['image_parallax_bgy_start'],
            'parallax_bgx_end' => $element['image_parallax_bgx_end'],
            'parallax_bgy_end' => $element['image_parallax_bgy_end'],
            'parallax_breakpoint' => $element['image_parallax_breakpoint']
        ]);

        $attrs_tile_container['class'][] = 'uk-grid-item-match';

        // Overlay
        if ($element['media_overlay']) {
            $attrs_tile_container['class'][] = 'uk-position-relative';
            $attrs_overlay['style'] = "background-color: {$element['media_overlay']};";
        }

    }

}

// Make sure overlay is always below content
if ($attrs_overlay) {
    $attrs_container['class'][] = 'uk-position-relative uk-panel';
}

// Text color
if ($element['style'] == 'primary' || $element['style'] == 'secondary') {
    $attrs_tile_container['class'][] = $element['preserve_color'] ? 'uk-preserve-color' : '';
} elseif (!$element['style'] || $element['image']) {
    $class[] = $element['text_color'] ? "uk-{$element['text_color']}" : '';
}

// Match height if single panel element inside cell
if ($element->parent['match'] && !$element->parent['vertical_align'] && count($element) == 1 && $element->children[0]->type == 'panel') {

    if ($element['style'] || $element['image']) {
        $attrs_tile['class'][] = 'uk-grid-item-match';
    } else {
        $class[] = 'uk-grid-item-match';
    }

    if ($attrs_container) {
        $attrs_container['class'][] = 'uk-grid-item-match';
    }

}

?>

<div<?= $this->attrs(compact('id', 'class')) ?>>

    <?php if ($attrs_tile) : ?>
    <div<?= $this->attrs($attrs_tile_container, !$attrs_image ? $attrs_tile : []) ?>>
    <?php endif ?>

        <?php if ($attrs_image) : ?>
        <div<?= $this->attrs($attrs_image, $attrs_tile) ?>>
        <?php endif ?>

            <?php if ($attrs_overlay) : ?>
            <div class="uk-position-cover"<?= $this->attrs($attrs_overlay) ?>></div>
            <?php endif ?>

            <?php if ($attrs_container) : ?>
            <div<?= $this->attrs($attrs_container) ?>>
            <?php endif ?>

                <?= $element ?>

            <?php if ($attrs_container) : ?>
            </div>
            <?php endif ?>

        <?php if ($attrs_image) : ?>
        </div>
        <?php endif ?>

    <?php if ($attrs_tile) : ?>
    </div>
    <?php endif ?>

</div>
