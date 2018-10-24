<?php

$attrs_title = [];

$attrs_title['class'][] = 'el-title';

// Style
$attrs_title['class'][] = $element['title_style'] ? "uk-{$element['title_style']}" : '';

// Color
$attrs_title['class'][] = $element['title_color'] && $element['title_color'] != 'background' ? "uk-text-{$element['title_color']}" : '';
$item['title'] = $element['title_color'] == 'background' ? "<span class=\"uk-text-background\">{$item['title']}</span>" : $item['title'];

?>

<?php if ($item['title']) : ?>
<div<?= $this->attrs($attrs_title) ?>><?= $item['title'] ?></div>
<?php endif ?>
