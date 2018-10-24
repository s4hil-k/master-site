<?php

$attrs_content = [];

$attrs_content['class'][] = 'el-content';
$attrs_content['class'][] = $element['content_style'] ? "uk-text-{$element['content_style']}" : '';

?>

<?php if ($item['content']) : ?>
<div<?= $this->attrs($attrs_content) ?>>
    <?= $item['content'] ?>
</div>
<?php endif ?>