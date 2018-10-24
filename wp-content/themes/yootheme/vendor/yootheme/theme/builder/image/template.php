<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_image = [];
$attrs_link = [];
$lightbox = '';
$attrs_lightbox = [];
$connect_id = 'js-' . substr(uniqid(), -3);

// Image
$attrs_image['class'][] = 'el-image';
$attrs_image['class'][] = $element['image_border'] ? "uk-border-{$element['image_border']}" : '';
$attrs_image['class'][] = $element['image_box_shadow'] ? "uk-box-shadow-{$element['image_box_shadow']}" : '';
$attrs_image['class'][] = $element['link'] && $element['image_hover_box_shadow'] ? "uk-box-shadow-hover-{$element['image_hover_box_shadow']}" : '';
$attrs_image['alt'] = $element['image_alt'];
$attrs_image['uk-img'] = true;

if ($this->isImage($element['image']) == 'gif') {
    $attrs_image['uk-gif'] = true;
}

if ($this->isImage($element['image']) == 'svg') {
    $attrs_image['uk-svg'] = $element['image_inline_svg'] ? true : false;
    $element['image'] = $this->image($element['image'], array_merge($attrs_image, ['width' => $element['image_width'], 'height' => $element['image_height']]));
} else {
    $element['image'] = $this->image([$element['image'], 'thumbnail' => [$element['image_width'], $element['image_height']], 'srcset' => true], $attrs_image);
}

// Link and Lightbox
if ($element['link_target'] == 'modal') {

    if ($this->isImage($element['link'])) {

        $attrs_lightbox['alt'] = '';
        $attrs_lightbox['uk-img'] = true;

        if ($this->isImage($element['link']) == 'svg') {
            $lightbox = $this->image($element['link'], array_merge($attrs_lightbox, ['width' => $element['lightbox_width'], 'height' => $element['lightbox_height']]));
        } else {
            $lightbox = $this->image([$element['link'], 'thumbnail' => [$element['lightbox_width'], $element['lightbox_height']], 'srcset' => true], $attrs_lightbox);
        }

    } elseif ($iframe = $this->iframeVideo($element['link']) or $this->isVideo($element['link'])) {

        $attrs_lightbox['width'] = $element['lightbox_width'];
        $attrs_lightbox['height'] = $element['lightbox_height'];
        $attrs_lightbox['uk-video'] = true;

        if ($iframe) {

            $attrs_lightbox['src'] = $iframe;
            $attrs_lightbox['frameborder'] = 0;

            $lightbox = "<iframe{$this->attrs($attrs_lightbox)}></iframe>";

        } else {

            $attrs_lightbox['src'] = $element['link'];
            $attrs_lightbox['controls'] = true;

            $lightbox = "<video{$this->attrs($attrs_lightbox)}></video>";

        }

    } else {

        $attrs_lightbox['src'] = $element['link'];
        $attrs_lightbox['width'] = $element['lightbox_width'];
        $attrs_lightbox['height'] = $element['lightbox_height'];
        $attrs_lightbox['frameborder'] = 0;

        $lightbox = "<iframe{$this->attrs($attrs_lightbox)}></iframe>";
    }

    $attrs_link['uk-toggle'] = true;
    $element['link'] = "#{$connect_id}";

} else {
    $attrs_link['target'] = $element['link_target'] == 'blank' ? '_blank' : '';
    $attrs_link['uk-scroll'] = strpos($element['link'], '#') === 0;
}

$attrs_link['class'][] = 'el-link';

// Box-shadow bottom
if ($element['image_box_shadow_bottom']) {
    if ($element['link']) {
        $attrs_link['class'][] = 'uk-box-shadow-bottom';
    } else {
        $element['image'] = "<div class=\"uk-box-shadow-bottom\">{$element['image']}</div>";
    }
}

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php if ($element['link']) : ?>
    <?= $this->link($element['image'], $element['link'], $attrs_link) ?>
    <?php else : ?>
    <?= $element['image'] ?>
    <?php endif ?>

    <?php if ($lightbox && $element['link_target'] == 'modal') : ?>
    <?php // uk-flex-top is needed to make vertical margin work for IE11 ?>
    <div id="<?= $connect_id ?>" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
            <button class="uk-modal-close-outside" type="button" uk-close></button>
            <?= $lightbox ?>
        </div>
    </div>
    <?php endif ?>

</div>
