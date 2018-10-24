<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_slider_items = [];
$attrs_slider_item = [];
$attrs_container = [];

// Slider
$options = [];
$options[] = $element['slider_sets'] ? 'sets: true' : '';
$options[] = $element['slider_center'] ? 'center: true' : '';
$options[] = $element['slider_finite'] ? 'finite: true' : '';
$options[] = $element['slider_velocity'] ? "velocity: {$element['slider_velocity']}" : '';

if ($element['slider_autoplay']) {
    $options[] = 'autoplay: true';
    $options[] = !$element['slider_autoplay_pause'] ? 'pauseOnHover: false' : '';
    $options[] = $element['slider_autoplay_interval'] ? "autoplayInterval: {$element['slider_autoplay_interval']}000" : '';
}

$attrs['uk-slider'] = implode(';', array_filter($options)) ?: true;

// Slider Items
$attrs_slider_items['class'][] = 'uk-slider-items';
$attrs_slider_item['class'][] = 'el-item';

if ($element['slider_width']) {

    $attrs_slider_item['class'][] = "uk-width-{$element['slider_width_default']}";
    $attrs_slider_item['class'][] = $element['slider_width_small'] ? "uk-width-{$element['slider_width_small']}@s" : '';
    $attrs_slider_item['class'][] = $element['slider_width_medium'] ? "uk-width-{$element['slider_width_medium']}@m" : '';
    $attrs_slider_item['class'][] = $element['slider_width_large'] ? "uk-width-{$element['slider_width_large']}@l" : '';
    $attrs_slider_item['class'][] = $element['slider_width_xlarge'] ? "uk-width-{$element['slider_width_xlarge']}@xl" : '';

}

if ($element['slider_gutter']) {

    $attrs_slider_items['class'][] = $element['slider_gutter'] == 'default' ? "uk-grid" : "uk-grid uk-grid-{$element['slider_gutter']}";
    $attrs_slider_items['class'][] = $element['slider_divider'] ? 'uk-grid-divider' : '';

}

// Height Viewport
if ($element['slider_width'] && $element['slider_height']) {

    $options = ['offset-top: true'];
    $options[] = $element['slider_min_height'] ? "minHeight: {$element['slider_min_height']}" : '';

    switch ($element['slider_height']) {
        case 'percent':
            $options[] = 'offset-bottom: 20';
            break;
        case 'section':
            $options[] = 'offset-bottom: !.uk-section +';
            break;
    }

    $attrs_slider_items['uk-height-viewport'] = implode(';', array_filter($options));
    $attrs_slider_items['class'][] = 'uk-grid-match';

}

// Container
$attrs_container['class'][] = 'uk-position-relative';
$attrs_container['class'][] = $element['slidenav'] && $element['slidenav_hover'] ? 'uk-visible-toggle' : '';

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <div<?= $this->attrs($attrs_container) ?>>

        <?php if ($element['slidenav'] == 'outside') : ?>
        <div class="uk-slider-container">
        <?php endif ?>

            <ul<?= $this->attrs($attrs_slider_items) ?>>

                <?php foreach ($element as $i => $item) : ?>
                <li<?= $this->attrs($attrs_slider_item) ?>><?= $this->render('@builder/slider/template-item', compact('item', 'i')) ?></li>
                <?php endforeach ?>

            </ul>

        <?php if ($element['slidenav'] == 'outside') : ?>
        </div>
        <?php endif ?>

        <?php if ($element['slidenav']) : ?>
        <?= $this->render('@builder/slider/template-slidenav', compact('item')) ?>
        <?php endif ?>

    </div>

    <?php if ($element['nav']): ?>
    <?= $this->render('@builder/slider/template-nav', compact('item')) ?>
    <?php endif ?>

</div>
