<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_link = [];

// Style
$class[] = $element['title_style'] ? "uk-{$element['title_style']}" : '';

// Decoration
$class[] = $element['title_decoration'] ? "uk-heading-{$element['title_decoration']}" : '';

// Color
$class[] = $element['title_color'] && $element['title_color'] != 'background' ? "uk-text-{$element['title_color']}" : '';

// Link
if ($element['link']) {

    $attrs_link['target'] = $element['link_target'] ? '_blank' : '';
    $attrs_link['uk-scroll'] = strpos($element['link'], '#') === 0;
    $attrs_link['class'][] = 'el-link';
    $attrs_link['class'][] = $element['link_style'] ? 'uk-link-heading' : 'uk-link-reset';

    $element['content'] = $this->link($element['content'], $element['link'], $attrs_link);

}

?>

<<?= $element['title_element'] . $this->attrs(compact('id', 'class'), $attrs) ?>>
    <?php if ($element['title_color'] == 'background') : ?>
    <span class="uk-text-background"><?= $element ?></span>
    <?php elseif ($element['title_decoration'] == 'line') : ?>
    <span><?= $element ?></span>
    <?php else : ?>
    <?= $element ?>
    <?php endif ?>
</<?= $element['title_element'] ?>>
