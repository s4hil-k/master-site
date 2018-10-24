<?php

$attrs_pull_push = [];
$attrs_pull_push_overlay = [];
$attrs_kenburns = [];
$attrs_image = [];
$attrs_video = [];
$attrs_position = [];
$attrs_overlay = [];

// Display
if (!$element['show_title']) { $item['title'] = ''; }
if (!$element['show_meta']) { $item['meta'] = ''; }
if (!$element['show_content']) { $item['content'] = ''; }
if (!$element['show_link']) { $item['link'] = ''; }
if (!$element['show_thumbnail']) { $item['thumbnail'] = ''; }

// Extra effect for pull/push
if (in_array($element['slideshow_animation'], ['push', 'pull'])) {

    $attrs_pull_push['class'][] = 'uk-position-cover';
    $attrs_pull_push_overlay['class'][] = 'uk-position-cover';

    $opacity = $item['text_color'] ? $item['text_color'] : ($element['text_color'] ? $element['text_color'] : '');
    $opacity = $opacity == 'light' ? '0.5' : '0.2';

    if ($element['slideshow_animation'] == 'push') {
        $attrs_pull_push['uk-slideshow-parallax'] = 'scale: 1.2,1.2,1';
        $attrs_pull_push_overlay['uk-slideshow-parallax'] = "opacity: 0,0,{$opacity}; backgroundColor: #000,#000";
    } else {
        $attrs_pull_push['uk-slideshow-parallax'] = 'scale: 1,1.2,1.2';
        $attrs_pull_push_overlay['uk-slideshow-parallax'] = "opacity: {$opacity},0,0; backgroundColor: #000,#000";
    }

}

// Kenburns
if ($element['slideshow_kenburns']) {

    $kenburns_alternate = [
        'center-left',
        'top-right',
        'bottom-left',
        'top-center',
        '', // center-center
        'bottom-right'
    ];

    if ($element['slideshow_kenburns'] == 'alternate') {
        $kenburns = $kenburns_alternate[$i % count($kenburns_alternate)];
    } elseif ($element['slideshow_kenburns'] == 'center-center') {
        $kenburns = '';
    } else {
        $kenburns = $element['slideshow_kenburns'];
    }

    $attrs_kenburns['class'][] = 'uk-position-cover uk-animation-kenburns uk-animation-reverse';
    $attrs_kenburns['class'][] = $kenburns ? "uk-transform-origin-{$kenburns}" : '';
    $attrs_kenburns['style'][] = $element['slideshow_kenburns_duration'] ? "-webkit-animation-duration: {$element['slideshow_kenburns_duration']}s; animation-duration: {$element['slideshow_kenburns_duration']}s;" : '';

}

// Blend mode
if ($item['media_blend_mode']) {
    if (in_array($element['slideshow_animation'], ['push', 'pull'])) {
        $attrs_pull_push['class'][] = "uk-blend-{$item['media_blend_mode']}";
    } elseif ($element['slideshow_kenburns']) {
        $attrs_kenburns['class'][] = "uk-blend-{$item['media_blend_mode']}";
    } elseif ($item['image']) {
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
    $attrs_image['uk-cover'] = true;
    $attrs_image['uk-img'] = 'target: !.uk-slideshow-items';

    if ($this->isImage($item['image']) == 'gif') {
        $attrs_image['uk-gif'] = true;
    }

    if ($this->isImage($item['image']) == 'svg') {
        $image = $this->image($item['image'], array_merge($attrs_image, ['width' => $element['image_width'], 'height' => $element['image_height']]));
    } else {
        $image = $this->image([$item['image'], 'thumbnail' => [$element['image_width'], $element['image_height']], 'srcset' => true, 'covers' => true], $attrs_image);
    }

}

// Video
if ($item['video'] && !$item['image']) {

    $attrs_video['class'][] = 'el-image';
    $attrs_video['uk-cover'] = true;

    if ($iframe = $this->iframeVideo($item['video'])) {

        $attrs_video['src'] = $iframe;
        $attrs_video['frameborder'] = '0';
        $attrs_video['allowfullscreen'] = true;

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

// Overlay
if ($item['title'] || $item['meta'] || $item['content'] || $item['link']) {

    // Position
    $attrs_position['class'][] = "uk-position-cover uk-flex";
    $attrs_position['class'][] = strpos($element['overlay_position'], 'top') !== false ? 'uk-flex-top' : '';
    $attrs_position['class'][] = strpos($element['overlay_position'], 'bottom') !== false ? 'uk-flex-bottom' : '';
    $attrs_position['class'][] = strpos($element['overlay_position'], 'left') !== false ? 'uk-flex-left' : '';
    $attrs_position['class'][] = strpos($element['overlay_position'], 'right') !== false ? 'uk-flex-right' : '';
    $attrs_position['class'][] = strpos($element['overlay_position'], '-center') !== false ? 'uk-flex-center' : '';
    $attrs_position['class'][] = strpos($element['overlay_position'], 'center-') !== false ? 'uk-flex-middle' : '';
    $attrs_position['class'][] = $element['overlay_position'] == 'center' ? 'uk-flex-center uk-flex-middle' : '';

    $attrs_overlay['class'][] = in_array($element['overlay_position'], ['top', 'bottom']) ? 'uk-flex-1' : '';

    if ($element['overlay_container']) {

        $attrs_position['class'][] = 'uk-container';
        $attrs_position['class'][] = $element['overlay_container'] != 'default' ? "uk-container-{$element['overlay_container']}" : '';
        $attrs_position['class'][] = $element['overlay_container_padding'] ? "uk-section-{$element['overlay_container_padding']}" : 'uk-section';

    } else {

        switch ($element['overlay_margin']) {
            case '':
                $attrs_position['class'][] = 'uk-padding';
                break;
            case 'none':
                break;
            default:
                $attrs_position['class'][] = "uk-padding-{$element['overlay_margin']}";
        }


    }

    // Overlay
    $attrs_overlay['class'][] = "el-overlay";

    switch ($element['overlay_style']) {
        case '':
            $attrs_overlay['class'][] = 'uk-panel';
            break;
        default:
            $attrs_overlay['class'][] = "uk-overlay uk-{$element['overlay_style']}";
    }

    $attrs_overlay['class'][] = $element['overlay_style'] && $element['overlay_padding'] ? "uk-padding-{$element['overlay_padding']}" : '';

    if (!in_array($element['overlay_position'], ['top', 'bottom'])) {
        $attrs_overlay['class'][] = $element['overlay_width'] ? "uk-width-{$element['overlay_width']}" : '';
    }

    // Animation
    if ($element['overlay_animation'] == 'parallax') {
        $options = [];
        foreach(['x', 'y', 'scale', 'rotate', 'opacity'] as $prop) {
            $start = $element["overlay_parallax_{$prop}_start"];
            $end = $element["overlay_parallax_{$prop}_end"];
            $default = in_array($prop, ['scale', 'opacity']) ? 1 : 0;
            $middle = in_array($prop, ['scale', 'opacity']) ? 1 : 0;

            if (strlen($start) || strlen($end)) {
                $options[] = "{$prop}: " . (strlen($start) ? $start : $default) . ",{$middle}," . (strlen($end) ? $end : $default);
            }
        }
        $attrs_overlay['uk-slideshow-parallax'] = implode(';', array_filter($options));
    } elseif ($element['overlay_animation']) {
        $attrs_overlay['class'][] = "uk-transition-{$element['overlay_animation']}";
    }

    // Text Color
    if (!$element['overlay_style']) {
        $attrs_overlay['class'][] = $item['text_color'] ? "uk-{$item['text_color']}" : ($element['text_color'] ? "uk-{$element['text_color']}" : '');
    }

}

?>

<?php if ($attrs_pull_push) : ?>
<div<?= $this->attrs($attrs_pull_push) ?>>
<?php endif ?>

    <?php if ($attrs_kenburns) : ?>
    <div<?= $this->attrs($attrs_kenburns) ?>>
    <?php endif ?>

        <?= $image ?>
        <?= $item['video'] ?>

    <?php if ($attrs_kenburns) : ?>
    </div>
    <?php endif ?>

<?php if ($attrs_pull_push) : ?>
</div>
<div<?= $this->attrs($attrs_pull_push_overlay) ?>></div>
<?php endif ?>

<?php if ($item['media_overlay']) : ?>
<div class="uk-position-cover" style="background-color:<?= $item['media_overlay'] ?>""></div>
<?php endif ?>


<?php if ($attrs_position) : ?>
<div<?= $this->attrs($attrs_position) ?>>
    <div<?= $this->attrs($attrs_overlay) ?>>

    <?= $this->render('@builder/slideshow/template-content', compact('item')) ?>

    </div>
</div>
<?php endif ?>
