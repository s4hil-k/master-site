<?php

$attrs_content = [];
$attrs_link = [];

$attrs_content['class'][] = 'el-content';
$attrs_content['class'][] = $element['content_style'] ? "uk-text-{$element['content_style']}" : '';

// Link
$attrs_link['class'][] = $element['link_style'] ? "uk-link-{$element['link_style']}" : '';
$attrs_link['target'] = $item['link_target'] ? '_blank' : '';
$attrs_link['uk-scroll'] = strpos($item['link'], '#') === 0;

?>

<?php if ($item['content']) : ?>
<div<?= $this->attrs($attrs_content) ?>>

    <?php if ($item['link']) : ?>
        <?= $this->link($item, $item['link'], $attrs_link) ?>
    <?php else : ?>
        <?= $item['content'] ?>
    <?php endif ?>

</div>
<?php endif ?>