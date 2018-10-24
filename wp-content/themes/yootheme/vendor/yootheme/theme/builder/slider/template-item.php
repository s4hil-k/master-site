<?php

$attrs_item = [];
$attrs_overlay = [];
$attrs_center = [];
$attrs_content = [];
$attrs_image = [];
$attrs_video = [];
$attrs_link = [];

// Display
if (!$element['show_title']) { $item['title'] = ''; }
if (!$element['show_meta']) { $item['meta'] = ''; }
if (!$element['show_content']) { $item['content'] = ''; }
if (!$element['show_link']) { $item['link'] = ''; }

// Needed for height viewport and overlay
$attrs_item['class'][] = 'uk-cover-container';

// Mode
if ($element['overlay_mode'] == 'cover' && $element['overlay_style']) {
    $attrs_overlay['class'][] = "uk-position-cover";
    $attrs_overlay['class'][] = $element['overlay_margin'] ? "uk-position-{$element['overlay_margin']}" : '';
}

// Style
switch ($element['overlay_style']) {
    case '':
        $attrs_content['class'][] = 'uk-panel';
        break;
    default:
        $attrs_overlay['class'][] = "uk-{$element['overlay_style']}";
        $attrs_content['class'][] = 'uk-overlay';
}

// Padding
switch ($element['overlay_padding']) {
    case '':
        $attrs_content['class'][] = !$element['overlay_style'] ? 'uk-padding' : '';
        break;
    case 'none':
        $attrs_content['class'][] = $element['overlay_style'] ? 'uk-padding-remove' : '';
        break;
    default:
        $attrs_content['class'][] = "uk-padding-{$element['overlay_padding']}";
}

// Position
if (in_array($element['overlay_position'], ['center', 'top-center', 'bottom-center', 'center-left', 'center-right'])) {
    $attrs_center['class'][] = "uk-position-{$element['overlay_position']}";
    $attrs_center['class'][] = $element['overlay_margin'] && $element['overlay_style'] ? "uk-position-{$element['overlay_margin']}" : '';
} else {
    $attrs_content['class'][] = "uk-position-{$element['overlay_position']}";
    $attrs_content['class'][] = $element['overlay_margin'] && $element['overlay_style'] ? "uk-position-{$element['overlay_margin']}" : '';
}

// Width
if (!in_array($element['overlay_position'], ['top', 'bottom'])) {
    $attrs_content['class'][] = $element['overlay_maxwidth'] ? "uk-width-{$element['overlay_maxwidth']}" : '';
}

// Transition
if ($element['overlay_hover'] || $element['image_transition']) {
    $attrs_item['class'][] = 'uk-transition-toggle';
    $attrs_item['tabindex'] = 0;
}

if ($element['overlay_hover']) {

    if ($element['overlay_transition_background'] && ($element['overlay_mode'] == 'cover' && $element['overlay_style'])) {
        $attrs_overlay['class'][] = "uk-transition-{$element['overlay_transition']}";
    } else {
        $attrs_overlay['class'][] = "uk-transition-{$element['overlay_transition']}";
        $attrs_content['class'][] = "uk-transition-{$element['overlay_transition']}";
    }

}

// Text color
if (!$element['overlay_style'] || ($element['overlay_mode'] == 'cover' && $element['overlay_style'])) {
    $attrs_item['class'][] = $item['text_color'] ? "uk-{$item['text_color']}" : ($element['text_color'] ? "uk-{$element['text_color']}" : '');
}

// Inverse text color on hover
if ($element['overlay_mode'] == 'cover' && $element['overlay_style'] && $element['overlay_transition_background']) {
    $attrs_item['uk-toggle'] = $item['text_color_hover'] || $element['text_color_hover'] ? "cls: uk-light uk-dark; mode: hover" : false;
}

// Background Color
$attrs_item['style'][] = $item['media_background'] ? "background-color: {$item['media_background']};" : '';

// Blend mode
if ($item['media_blend_mode']) {
    if ($item['image']) {
        $attrs_image['class'][] = "uk-blend-{$item['media_blend_mode']}";
    } elseif ($item['video']) {
        $attrs_video['class'][] = "uk-blend-{$item['media_blend_mode']}";
    }
}

$image = '';

// Image
if ($item['image']) {

    $attrs_image['class'][] = 'el-image';
    $attrs_image['alt'] = $item['image_alt'];
    $attrs_image['uk-cover'] = $element['slider_width'] && $element['slider_height'] ? true : false;
    $attrs_image['uk-img'] = 'target: !.uk-slider-items';

    if ($element['slider_width'] && $element['slider_height']) {
        $attrs_image['uk-cover'] = true;
    } else {
        $attrs_image['class'][] = $element['image_transition'] ? "uk-transition-{$element['image_transition']} uk-transition-opaque" : '';
    }

    if ($this->isImage($item['image']) == 'gif') {
        $attrs_image['uk-gif'] = true;
    }

    if ($this->isImage($item['image']) == 'svg') {
        $image = $this->image($item['image'], array_merge($attrs_image, ['width' => $element['image_width'], 'height' => $element['image_height']]));
    } else {
        $image = $this->image([$item['image'], 'thumbnail' => [$element['image_width'], $element['image_height']], 'srcset' => true, 'covers' => $attrs_image['uk-cover']], $attrs_image);
    }

}

// Video
if ($item['video'] && !$item['image']) {

    $attrs_video['class'][] = 'el-image';
    $attrs_video['width'] = $element['image_width'];
    $attrs_video['height'] = $element['image_height'];
    $attrs_video['uk-cover'] = $element['slider_width'] && $element['slider_height'] ? true : false;

    if ($element['slider_width'] && $element['slider_height']) {
        $attrs_video['uk-cover'] = true;
    } else {
        $attrs_video['uk-video'] = 'automute: true';
        $attrs_video['class'][] = $element['image_transition'] ? "uk-transition-{$element['image_transition']} uk-transition-opaque" : '';
    }

    if ($iframe = $this->iframeVideo($item['video'])) {

        $attrs_video['src'] = $iframe;
        $attrs_video['frameborder'] = '0';
        $attrs_video['allowfullscreen'] = true;
        $attrs_video['class'][] = 'uk-disabled';
        $attrs_video['uk-responsive'] = !$element['slider_width'] || ($element['slider_width'] && !$element['slider_height']) ? true : false;

        $item['video'] = "<iframe{$this->attrs($attrs_video)}></iframe>";

    } else if ($item['video']) {

        $attrs_video['src'] = $item['video'];
        $attrs_video['controls'] = false;
        $attrs_video['loop'] = true;
        $attrs_video['autoplay'] = true;
        $attrs_video['muted'] = true;
        $attrs_video['playsinline'] = true;

        $item['video'] = "<video{$this->attrs($attrs_video)}></video>";
    }

} else {
    $item['video'] = '';
}

// Link
$attrs_link['target'] = $element['link_target'] ? '_blank' : '';
$attrs_link['uk-scroll'] = strpos($item['link'], '#') === 0;
$attrs_link['href'] = $item['link'];
$attrs_link['class'][] = 'uk-position-cover';

?>

<div<?= $this->attrs($attrs_item) ?>>

    <?php if ($element['slider_width'] && $element['slider_height'] && $element['image_transition']) : ?>
    <div class="uk-position-cover <?= $element['image_transition'] ? "uk-transition-{$element['image_transition']} uk-transition-opaque" : '' ?>">
    <?php endif ?>

        <?= $image ?>
        <?= $item['video'] ?>

    <?php if ($element['slider_width'] && $element['slider_height'] && $element['image_transition']) : ?>
    </div>
    <?php endif ?>

    <?php if ($item['media_overlay']) : ?>
    <div class="uk-position-cover" style="background-color:<?= $item['media_overlay'] ?>""></div>
    <?php endif ?>

    <?php if ($element['overlay_mode'] == 'cover' && $element['overlay_style']) : ?>
    <div<?= $this->attrs($attrs_overlay) ?>></div>
    <?php endif ?>

    <?php if ($item['title'] || $item['meta'] || $item['content']) : ?>

        <?php if ($attrs_center) : ?>
        <div<?= $this->attrs($attrs_center) ?>>
        <?php endif ?>

            <div<?= $this->attrs($attrs_content, !($element['overlay_mode'] == 'cover' && $element['overlay_style']) ? $attrs_overlay : []) ?>>
                <?= $this->render('@builder/slider/template-content') ?>
            </div>

        <?php if ($attrs_center) : ?>
        </div>
        <?php endif ?>

    <?php endif ?>

    <?php if ($item['link']) : ?>
    <a<?= $this->attrs($attrs_link) ?>></a>
    <?php endif ?>

</div>
