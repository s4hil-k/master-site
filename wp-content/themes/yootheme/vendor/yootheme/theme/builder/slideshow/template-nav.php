<?php

$attrs_nav = [];
$attrs_nav_container = [];

$attrs_nav['class'][] = 'el-nav';

// Style
$attrs_nav['class'][] = $element['nav'] ? "uk-{$element['nav']}" : '';

if ($element['nav_below']) {

    // Alignment
    $attrs_nav['class'][] = "uk-flex-{$element['nav_align']}";

    // Margin
    switch ($element['nav_margin']) {
        case '':
            $attrs_nav_container['class'][] = 'uk-margin-top';
            break;
        default:
            $attrs_nav_container['class'][] = "uk-margin-{$element['nav_margin']}-top";
    }

    // Color
    $attrs_nav_container['class'][] = $element['nav_color'] ? "uk-{$element['nav_color']}" : '';

} else {

    // Position
    $attrs_nav_container['class'][] = "uk-position-{$element['nav_position']}";

    // Margin
    $attrs_nav_container['class'][] = $element['nav_position_margin'] ? "uk-position-{$element['nav_position_margin']}" : '';

    // Text Color
    $attrs_nav_container['class'][] = $element['text_color'] ? "uk-{$element['text_color']}" : '';

    // Vertical
    $attrs_nav['class'][] = $element['nav_vertical'] ? "uk-{$element['nav']}-vertical" : '';

}

// Wrapping
if (!$element['nav_vertical']) {

    $attrs_nav['uk-margin'] = true;

    if (!$element['nav_below']) {
        switch ($element['nav_position']) {
            case 'top-right':
            case 'center-right':
            case 'bottom-right':
                $attrs_nav['class'][] = 'uk-flex-right';
                break;
            case 'bottom-center':
                $attrs_nav['class'][] = 'uk-flex-center';
                break;
        }
    }
}

// Breakpoint
$attrs_nav_container['class'][] = $element['nav_breakpoint'] ? "uk-visible@{$element['nav_breakpoint']}" : '';

?>

<?php if (!$element['nav_below'] || ($element['nav_below'] && $element['nav_color'])) : ?>
<div<?= $this->attrs($attrs_nav_container) ?>>
<?php endif ?>

<ul<?= $this->attrs($attrs_nav, $element['nav_below'] && !$element['nav_color'] ? $attrs_nav_container : []) ?>>
    <?php foreach ($element as $i => $item) :

        // Display
        if (!$element['show_title']) { $item['title'] = ''; }
        if (!$element['show_thumbnail']) { $item['thumbnail'] = ''; }

        // Image
        $thumbnail = '';
        $src = $item['thumbnail'] ? $item['thumbnail'] : $item['image'];

        if ($element['nav'] == 'thumbnav' && $src) {

            $attrs_thumbnail['alt'] = $item['image_alt'];
            $attrs_thumbnail['uk-img'] = true;

            if ($this->isImage($src) == 'svg') {
                $thumbnail = $this->image($src, array_merge($attrs_thumbnail, ['width' => $element['thumbnav_width'], 'height' => $element['thumbnav_height']]));
            } else {
                $thumbnail = $this->image([$src, 'thumbnail' => [$element['thumbnav_width'], $element['thumbnav_height']], 'srcset' => true], $attrs_thumbnail);
            }

        }

    ?>
    <li uk-slideshow-item="<?= $i ?>">
        <a href="#"><?= $thumbnail ? $thumbnail : $item['title'] ?></a>
    </li>
    <?php endforeach ?>
</ul>

<?php if (!$element['nav_below'] || ($element['nav_below'] && $element['nav_color'])) : ?>
</div>
<?php endif ?>
