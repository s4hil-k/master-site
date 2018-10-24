<?php

$attrs_link = [];

// Link
$attrs_link['href'] = $item['link'];
$attrs_link['target'] = $element['link_target'] ? '_blank' : '';
$attrs_link['uk-scroll'] = strpos($item['link'], '#') === 0;

$attrs_link['class'][] = 'el-link';

switch ($element['link_style']) {
    case '':
        break;
    case 'link-muted':
    case 'link-text':
        $attrs_link['class'][] = "uk-{$element['link_style']}";
        break;
    default:
        $attrs_link['class'][] = "uk-button uk-button-{$element['link_style']}";
        $attrs_link['class'][] = $element['link_size'] ? "uk-button-{$element['link_size']}" : '';
        if ($element['link_fullwidth'] && $element['link_style'] != 'text') {
            $attrs_link['class'][] = $element['table_responsive'] == 'responsive' ? 'uk-width-auto uk-width-1-1@m' : 'uk-width-1-1';
        }
}

?>

<?php if ($item['link'] && ($item['link_text'] || $element['link_text'])) : ?>
<a<?= $this->attrs($attrs_link) ?>><?= $item['link_text'] ? $item['link_text'] : $element['link_text'] ?></a>
<?php endif ?>