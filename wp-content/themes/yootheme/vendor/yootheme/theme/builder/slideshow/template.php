<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_slideshow_items = [];
$attrs_container = [];

// Slideshow
$options = [];
if (!$element['slideshow_height']) {
    $options[] = $element['slideshow_ratio'] ? "ratio: {$element['slideshow_ratio']}" : '';
    $options[] = $element['slideshow_min_height'] ? "minHeight: {$element['slideshow_min_height']}" : '';
    $options[] = $element['slideshow_max_height'] ? "maxHeight: {$element['slideshow_max_height']}" : '';
}
$options[] = $element['slideshow_animation'] ? "animation: {$element['slideshow_animation']}" : '';
$options[] = $element['slideshow_velocity'] ? "velocity: {$element['slideshow_velocity']}" : '';

if ($element['slideshow_autoplay']) {
    $options[] = 'autoplay: true';
    $options[] = !$element['slideshow_autoplay_pause'] ? 'pauseOnHover: false' : '';
    $options[] = $element['slideshow_autoplay_interval'] ? "autoplayInterval: {$element['slideshow_autoplay_interval']}000" : '';
}

$attrs['uk-slideshow'] = implode(';', array_filter($options)) ?: true;

// Slideshow items
$attrs_slideshow_items['class'][] = 'uk-slideshow-items';
$attrs_slideshow_items['class'][] = $element['slideshow_box_shadow'] ? "uk-box-shadow-{$element['slideshow_box_shadow']}" : '';

// Height Viewport
if ($element['slideshow_height']) {

    $options = ['offset-top: true'];
    $options[] = $element['slideshow_min_height'] ? "minHeight: {$element['slideshow_min_height']}" : '';

    switch ($element['slideshow_height']) {
        case 'percent':
            $options[] = 'offset-bottom: 20';
            break;
        case 'section':
            $options[] = 'offset-bottom: !.uk-section +';
            break;
    }

    $attrs_slideshow_items['uk-height-viewport'] = implode(';', array_filter($options));

}

// Container
$attrs_container['class'][] = 'uk-position-relative';
$attrs_container['class'][] = $element['slidenav'] && $element['slidenav_hover'] ? 'uk-visible-toggle' : '';

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <div<?= $this->attrs($attrs_container) ?>>

        <?php if ($element['slideshow_box_shadow_bottom']) : ?>
        <div class="uk-box-shadow-bottom uk-display-block">
        <?php endif ?>

            <ul<?= $this->attrs($attrs_slideshow_items) ?>>

                <?php foreach ($element as $i => $item) : ?>
                <li class="el-item" <?= $item['media_background'] ? "style=\"background-color: {$item['media_background']};\"" : ''; ?>><?= $this->render('@builder/slideshow/template-item', compact('item', 'i')) ?></li>
                <?php endforeach ?>

            </ul>

        <?php if ($element['slideshow_box_shadow_bottom']) : ?>
        </div>
        <?php endif ?>

        <?php if ($element['slidenav']) : ?>
        <?= $this->render('@builder/slideshow/template-slidenav', compact('item')) ?>
        <?php endif ?>

        <?php if ($element['nav'] && !$element['nav_below']) : ?>
        <?= $this->render('@builder/slideshow/template-nav', compact('item')) ?>
        <?php endif ?>

    </div>

    <?php if ($element['nav'] && $element['nav_below']): ?>
    <?= $this->render('@builder/slideshow/template-nav', compact('item')) ?>
    <?php endif ?>

</div>
