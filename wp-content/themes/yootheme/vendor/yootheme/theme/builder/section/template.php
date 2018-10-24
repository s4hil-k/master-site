<?php

$id = $element['id'];
$class = $element['class'];
$style = [];
$attrs = [
    'uk-scrollspy' => $element['animation'] ? json_encode([
        'target' => '[uk-scrollspy-class]',
        'cls' => "uk-animation-{$element['animation']}",
        'delay' => $element['animation_delay'] ? 200 : false,
    ]) : false,
    'tm-header-transparent' => $element['header_transparent'] ? $element['header_transparent'] : false,
    'tm-header-transparent-placeholder' => $element['header_transparent'] && !$element['header_transparent_noplaceholder']
];
$attrs_overlay = [];
$attrs_container = [];
$attrs_viewport_height = [];
$attrs_image = [];
$attrs_video = [];
$attrs_section = [];
$attrs_section_title = [];
$attrs_section_title_container = [];

// Section
$class[] = "uk-section-{$element['style']}";
$class[] = $element['overlap'] ? 'uk-section-overlap' : '';
$attrs_section['class'][] = 'uk-section';

// Section Title
if ($element['title']) {

    $attrs_section_title_container['class'][] = 'uk-position-relative';

    $attrs_section_title['class'][] = 'tm-section-title';
    $attrs_section_title['class'][] = "uk-position-{$element['title_position']} uk-position-medium";
    $attrs_section_title['class'][] = !in_array($element['title_position'], ['center-left', 'center-right']) ? 'uk-margin-remove-vertical' : 'uk-text-nowrap';
    $attrs_section_title['class'][] = $element['title_breakpoint'] ? "uk-visible@{$element['title_breakpoint']}" : '';

}

// Image
if ($element['image']) {

    $attrs_image = $this->bgImage($element['image'], [
        'width' => $element['image_width'],
        'height' => $element['image_height'],
        'size' => $element['image_size'],
        'position' => $element['image_position'],
        'visibility' => $element['image_visibility'],
        'blend_mode' => $element['media_blend_mode'],
        'background' => $element['media_background'],
        'effect' => $element['image_effect'],
        'parallax_bgx_start' => $element['image_parallax_bgx_start'],
        'parallax_bgy_start' => $element['image_parallax_bgy_start'],
        'parallax_bgx_end' => $element['image_parallax_bgx_end'],
        'parallax_bgy_end' => $element['image_parallax_bgy_end'],
        'parallax_breakpoint' => $element['image_parallax_breakpoint'],
    ]);

    // Overlay
    if ($element['media_overlay']) {
        $class[] = 'uk-position-relative';
        $attrs_overlay['style'] = "background-color: {$element['media_overlay']};";
    }

}

// Video
if ($element['video'] && !$element['image']) {

    // Settings
    $style[] = $element['media_background'] ? "background-color: {$element['media_background']};" : '';
    $attrs_video['class'][] = $element['media_blend_mode'] ? "uk-blend-{$element['media_blend_mode']}" : '';

    // Cover
    $class[] = 'uk-cover-container';
    $attrs_video['uk-cover'] = true;

    // Overlay
    $attrs_overlay['style'] = $element['media_overlay'] ? "background-color: {$element['media_overlay']};" : '';

    // Video
    $attrs_video['width'] = $element['video_width'];
    $attrs_video['height'] = $element['video_height'];

    if ($iframe = $this->iframeVideo($element['video'])) {

        $attrs_video['src'] = $iframe;
        $attrs_video['frameborder'] = '0';
        $attrs_video['allowfullscreen'] = true;

        $element['video'] = "<iframe{$this->attrs($attrs_video)}></iframe>";

    } else if ($element['video']) {

        $attrs_video['src'] = $element['video'];
        $attrs_video['controls'] = false;
        $attrs_video['loop'] = true;
        $attrs_video['autoplay'] = true;
        $attrs_video['muted'] = true;
        $attrs_video['playsinline'] = true;

        $element['video'] = "<video{$this->attrs($attrs_video)}></video>";
    }

} else {
    $element['video'] = '';
}

// Text color
if ($element['style'] == 'primary' || $element['style'] == 'secondary') {
    $class[] = $element['preserve_color'] ? 'uk-preserve-color' : '';
} elseif ($element['image'] || $element['video']) {
    $class[] = $element['text_color'] ? "uk-{$element['text_color']}" : '';
}

// Padding
switch ($element['padding']) {
    case '':
        break;
    case 'none':
        $attrs_section['class'][] = 'uk-padding-remove-vertical';
        break;
    default:
        $attrs_section['class'][] = "uk-section-{$element['padding']}";
}

if ($element['padding'] != 'none') {
    if ($element['padding_remove_top']) {
        $attrs_section['class'][] = 'uk-padding-remove-top';
    }
    if ($element['padding_remove_bottom']) {
        $attrs_section['class'][] = 'uk-padding-remove-bottom';
    }
}

// Height Viewport
if ($element['height']) {

    if ($element['height'] == 'expand') {
        $attrs_section['uk-height-viewport'] = 'expand: true';
    } else {

        // Vertical alignment
        if ($element['vertical_align']) {

            if ($element['title']) {
                $attrs_section['class'][] = 'uk-flex';
                $attrs_section_title_container['class'][] = "uk-flex-auto uk-flex uk-flex-{$element['vertical_align']}";
            } else {
                $attrs_section['class'][] = "uk-flex uk-flex-{$element['vertical_align']}";
            }

            $attrs_viewport_height['class'][] = 'uk-width-1-1';
        }

        $options = ['offset-top: true'];
        switch ($element['height']) {
            case 'percent':
                $options[] = 'offset-bottom: 20';
                break;
            case 'section':
                $options[] = $element['image'] ? 'offset-bottom: ! +' : 'offset-bottom: true';
                break;
        }

        $attrs_section['uk-height-viewport'] = implode(';', array_filter($options));

    }

}

// Container and width
switch ($element['width']) {
    case 'default':
        $attrs_container['class'][] = 'uk-container';
        break;
    case 'small':
    case 'large':
    case 'expand':
        $attrs_container['class'][] = "uk-container uk-container-{$element['width']}";
        break;
    // Deprecated
    case 1:
        $attrs_container['class'][] = 'uk-container';
        break;
    case 2:
        $attrs_container['class'][] = 'uk-container uk-container-small';
        break;
    case 3:
        $attrs_container['class'][] = 'uk-container uk-container-expand';
}

// Make sure overlay and video is always below content
if ($attrs_overlay || $element['video']) {
    $attrs_container['class'][] = $element['width'] ? 'uk-position-relative' : 'uk-position-relative uk-panel';
}

// Visibility
$visible = 4;
$visibilities = ['xs', 's', 'm', 'l', 'xl'];

foreach ($element as $el) {
    $visible = min(array_search($el['visibility'], $visibilities), $visible);
}

if ($visible) {
    $element['visibility'] = $visibilities[$visible];
    $class[] = "uk-visible@{$visibilities[$visible]}";
}

?>

<div<?= $this->attrs(compact('id', 'class', 'style'), $attrs, !$attrs_image ? $attrs_section : []) ?>>

    <?php if ($attrs_image) : ?>
    <div<?= $this->attrs($attrs_image, $attrs_section) ?>>
    <?php endif ?>

        <?= $element['video'] ?>

        <?php if ($attrs_overlay) : ?>
        <div class="uk-position-cover"<?= $this->attrs($attrs_overlay) ?>></div>
        <?php endif ?>

        <?php if ($element['title']) : ?>
        <div<?= $this->attrs($attrs_section_title_container) ?>>
        <?php endif ?>

            <?php if ($attrs_viewport_height) : ?>
            <div<?= $this->attrs($attrs_viewport_height) ?>>
            <?php endif ?>

                <?php if ($attrs_container) : ?>
                <div<?= $this->attrs($attrs_container) ?>>
                <?php endif ?>

                    <?= $element ?>

                <?php if ($attrs_container) : ?>
                </div>
                <?php endif ?>

            <?php if ($attrs_viewport_height) : ?>
            </div>
            <?php endif ?>

        <?php if ($element['title']) : ?>
            <div<?= $this->attrs($attrs_section_title) ?>>
                <div class="<?= $element['title_rotation'] == 'left' ? 'tm-rotate-180' : '' ?>"><?= $element['title'] ?></div>
            </div>
        </div>
        <?php endif ?>

    <?php if ($attrs_image) : ?>
    </div>
    <?php endif ?>

</div>
