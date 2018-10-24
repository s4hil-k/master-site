<?php

$attrs_marker = [];
$attrs_drop = [];

// Marker
$attrs_marker['class'][] = 'el-marker uk-position-absolute uk-transform-center';
$attrs_marker['uk-marker'] = true;

$item['position_x'] = rtrim($item['position_x'], '%');
$item['position_y'] = rtrim($item['position_y'], '%');

$attrs_marker['style'][] = $item['position_x'] != null ? "left: {$item['position_x']}%;" : 'left: 50%;';
$attrs_marker['style'][] = $item['position_y'] != null ? "top: {$item['position_y']}%;" : 'top: 50%;';

// Drop
$attrs_drop['uk-drop'][] = $item['drop_position'] ? "pos: {$item['drop_position']};" : "pos: {$element['drop_position']};";
$attrs_drop['uk-drop'][] = ($element['drop_mode'] == 'click') ? "mode: {$element['drop_mode']};" : '';

$element['drop_width'] = rtrim($element['drop_width'], 'px');
$attrs_drop['style'][] = $element['drop_width'] ? "width: {$element['drop_width']}px;" : 'width: 300px;';

?>

<a<?= $this->attrs($attrs_marker) ?> href="#"></a>

<div<?= $this->attrs($attrs_drop) ?>>
    <?= $this->render('@builder/popover/template-item', compact('item')) ?>
</div>
