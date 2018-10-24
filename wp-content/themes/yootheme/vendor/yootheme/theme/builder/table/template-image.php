<?php

$attrs_image = [];

// Image
if ($item['image']) {

    $attrs_image['class'][] = 'el-image uk-preserve-width';
    $attrs_image['class'][] = $element['image_border'] ? "uk-border-{$element['image_border']}" : '';
    $attrs_image['class'][] = $element['image_box_shadow'] ? "uk-box-shadow-{$element['image_box_shadow']}" : '';
    $attrs_image['alt'] = $item['image_alt'];
    $attrs_image['uk-img'] = true;

    if ($this->isImage($item['image']) == 'gif') {
        $attrs_image['uk-gif'] = true;
    }

    if ($this->isImage($item['image']) == 'svg') {
        $item['image'] = $this->image($item['image'], array_merge($attrs_image, ['width' => $element['image_width'], 'height' => $element['image_height']]));
    } else {
        $item['image'] = $this->image([$item['image'], 'thumbnail' => [$element['image_width'], $element['image_height']], 'srcset' => true], $attrs_image);
    }

}

?>

<?= $item['image'] ?>
