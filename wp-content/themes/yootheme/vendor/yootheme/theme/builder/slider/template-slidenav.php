<?php

$attrs_slidenav = [];
$attrs_slidenav_next = [];
$attrs_slidenav_previous = [];
$attrs_slidenav_container = [];

$attrs_slidenav['class'][] = 'el-slidenav';
$attrs_slidenav['href'] = '#';

$attrs_slidenav_previous['uk-slidenav-previous'] = true;
$attrs_slidenav_next['uk-slidenav-next'] = true;

$attrs_slidenav_previous['uk-slider-item'] = 'previous';
$attrs_slidenav_next['uk-slider-item'] = 'next';

// Position + Margin
if ($element['slidenav'] == 'default') {

    $attrs_slidenav_previous['class'][] = 'uk-position-center-left';
    $attrs_slidenav_next['class'][] = 'uk-position-center-right';
    $attrs_slidenav['class'][] = $element['slidenav_margin'] ? "uk-position-{$element['slidenav_margin']}" : '';

} elseif ($element['slidenav'] == 'outside') {

    $attrs_slidenav_previous['class'][] = 'uk-position-center-left-out';
    $attrs_slidenav_next['class'][] = 'uk-position-center-right-out';

    $attrs_slidenav_previous['uk-toggle'] = "cls: uk-position-center-left-out uk-position-center-left; mode: media; media: @{$element['slidenav_outside_breakpoint']}";
    $attrs_slidenav_next['uk-toggle'] = "cls: uk-position-center-right-out uk-position-center-right; mode: media; media: @{$element['slidenav_outside_breakpoint']}";

    $attrs_slidenav['class'][] = $element['slidenav_margin'] ? "uk-position-{$element['slidenav_margin']}" : '';

} else {

    $attrs_slidenav_container['class'][] = 'uk-slidenav-container';
    $attrs_slidenav_container['class'][] = "uk-position-{$element['slidenav']}";
    $attrs_slidenav_container['class'][] = $element['slidenav_margin'] ? "uk-position-{$element['slidenav_margin']}" : '';

}

// Hover
$attrs_slidenav_container['class'][] = $element['slidenav_hover'] ? 'uk-hidden-hover uk-hidden-touch' : '';

// Large
$attrs_slidenav['class'][] = $element['slidenav_large'] ? 'uk-slidenav-large' : '';

// Breakpoint
$attrs_slidenav_container['class'][] = $element['slidenav_breakpoint'] ? "uk-visible@{$element['slidenav_breakpoint']}" : '';

// Color
if ($element['slidenav'] == 'outside' && ($element['slidenav_color'] != $element['slidenav_outside_color'])) {
    if (!$element['slidenav_color']) {
        $attrs_slidenav_container['uk-toggle'] = "cls: js-color-state uk-{$element['slidenav_outside_color']}; mode: media; media: @{$element['slidenav_outside_breakpoint']}";
        $attrs_slidenav_container['class'][] = "js-color-state uk-{$element['slidenav_outside_color']}";
    } elseif (!$element['slidenav_outside_color']) {
        $attrs_slidenav_container['uk-toggle'] = "cls: js-color-state uk-{$element['slidenav_color']}; mode: media; media: @{$element['slidenav_outside_breakpoint']}";
        $attrs_slidenav_container['class'][] = "js-color-state";
    } else {
        $attrs_slidenav_container['uk-toggle'] = "cls: uk-{$element['slidenav_outside_color']} uk-{$element['slidenav_color']}; mode: media; media: @{$element['slidenav_outside_breakpoint']}";
        $attrs_slidenav_container['class'][] = "uk-{$element['slidenav_outside_color']}";
    }
} else {
    $attrs_slidenav_container['class'][] = $element['slidenav_color'] ? "uk-{$element['slidenav_color']}" : '';
}

?>

<div<?= $this->attrs($attrs_slidenav_container) ?>>
    <a <?= $this->attrs($attrs_slidenav, $attrs_slidenav_previous) ?>></a>
    <a <?= $this->attrs($attrs_slidenav, $attrs_slidenav_next) ?>></a>
</div>