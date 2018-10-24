<?php

$attrs_nav = [];
$attrs_nav_container = [];

$attrs_nav['class'][] = 'el-nav uk-slider-nav';

// Style
$attrs_nav['class'][] = $element['nav'] ? "uk-{$element['nav']}" : '';

// Alignment
$attrs_nav['class'][] = "uk-flex-{$element['nav_align']}";

// Margin
switch ($element['nav_margin']) {
    case '':
        $attrs_nav_container['class'][] = 'uk-margin-top';
        break;
    default:
        $attrs_nav_container['class'][] = "uk-margin-{$element['nav_margin']}-top";
}

// Wrapping
$attrs_nav['uk-margin'] = true;

// Breakpoint
$attrs_nav_container['class'][] = $element['nav_breakpoint'] ? "uk-visible@{$element['nav_breakpoint']}" : '';

// Color
$attrs_nav_container['class'][] = $element['nav_color'] ? "uk-{$element['nav_color']}" : '';

?>

<?php if ($element['nav_color']) : ?>
<div<?= $this->attrs($attrs_nav_container) ?>>
<?php endif ?>

    <ul<?= $this->attrs($attrs_nav, !$element['nav_color'] ? $attrs_nav_container : []) ?>></ul>

<?php if ($element['nav_color']) : ?>
</div>
<?php endif ?>