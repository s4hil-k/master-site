<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_grid = [];

// Grid
$attrs_grid['class'][] = 'uk-flex-middle';
$attrs_grid['class'][] = $element['fullwidth'] ? 'uk-child-width-1-1' : 'uk-child-width-auto';
$attrs_grid['class'][] = $element['gutter'] ? "uk-grid-{$element['gutter']}" : '';
$attrs_grid['uk-grid'] = true;

// Flex alignment
if (!$element['fullwidth']) {
    if ($element['text_align'] && $element['text_align_breakpoint']) {
        $attrs_grid['class'][] = "uk-flex-{$element['text_align']}@{$element['text_align_breakpoint']}";
        if ($element['text_align_fallback']) {
            $attrs_grid['class'][] = "uk-flex-{$element['text_align_fallback']}";
        }
    } else if ($element['text_align']) {
        $attrs_grid['class'][] = "uk-flex-{$element['text_align']}";
    }
}

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php if (count($element) > 1) : ?>
    <div<?= $this->attrs($attrs_grid) ?>>
    <?php endif ?>

    <?php foreach ($element as $item) :

        $attrs_button = [];
        $lightbox = '';
        $attrs_lightbox = [];
        $connect_id = 'js-' . substr(uniqid(), -3);

        $attrs_button['class'][] = 'el-content';

        // Fullwidth
        $attrs_button['class'][] = $element['fullwidth'] ? 'uk-width-1-1' : '';

        // Deprecated
        if ($item['button_style'] == 'muted') {
            $item['button_style'] = 'link-muted';
        }

        // Style
        switch ($item['button_style']) {
            case '':
                break;
            case 'link-muted':
            case 'link-text':
                $attrs_button['class'][] = "uk-{$item['button_style']}";
                break;
            default:
                $attrs_button['class'][] = "uk-button uk-button-{$item['button_style']}";
                $attrs_button['class'][] = $element['button_size'] ? "uk-button-{$element['button_size']}" : '';
        }

        // Link and Lightbox
        if ($item['link_target'] == 'modal') {

            if ($this->isImage($item['link'])) {

                $attrs_lightbox['alt'] = '';
                $attrs_lightbox['uk-img'] = true;

                if ($this->isImage($item['link']) == 'svg') {
                    $lightbox = $this->image($item['link'], array_merge($attrs_lightbox, ['width' => $item['lightbox_width'], 'height' => $item['lightbox_height']]));
                } else {
                    $lightbox = $this->image([$item['link'], 'thumbnail' => [$item['lightbox_width'], $item['lightbox_height']], 'srcset' => true], $attrs_lightbox);
                }

            } elseif ($iframe = $this->iframeVideo($item['link'], [], false) or $this->isVideo($item['link'])) {

                $attrs_lightbox['width'] = $item['lightbox_width'];
                $attrs_lightbox['height'] = $item['lightbox_height'];
                $attrs_lightbox['uk-video'] = true;

                if ($iframe) {

                    $attrs_lightbox['src'] = $iframe;
                    $attrs_lightbox['frameborder'] = 0;
                    $attrs_lightbox['uk-responsive'] = true;

                    $lightbox = "<iframe{$this->attrs($attrs_lightbox)}></iframe>";

                } else {

                    $attrs_lightbox['src'] = $item['link'];
                    $attrs_lightbox['controls'] = true;

                    $lightbox = "<video{$this->attrs($attrs_lightbox)}></video>";

                }

            } else {

                $attrs_lightbox['src'] = $item['link'];
                $attrs_lightbox['width'] = $item['lightbox_width'];
                $attrs_lightbox['height'] = $item['lightbox_height'];
                $attrs_lightbox['frameborder'] = 0;
                $attrs_lightbox['uk-responsive'] = true;

                $lightbox = "<iframe{$this->attrs($attrs_lightbox)}></iframe>";
            }

            $attrs_button['uk-toggle'] = true;
            $attrs_button['href'] = "#{$connect_id}";

        } else {
            $attrs_button['href'] = $item['link'];
            $attrs_button['target'] = $item['link_target'] == 'blank' ? '_blank' : '';
            $attrs_button['uk-scroll'] = strpos($item['link'], '#') === 0;
        }

        $attrs_button['title'] = $item['link_title'];

        ?>

        <?php if (count($element) > 1) : ?>
        <div class="el-item">
        <?php endif ?>

            <a<?= $this->attrs($attrs_button) ?>>

                <?php if ($item['icon']) : ?>

                    <?php if ($item['icon_align'] == 'left') : ?>
                    <span uk-icon="<?= $item['icon'] ?>"></span>
                    <?php endif ?>

                    <span class="uk-text-middle"><?= $item['content'] ?></span>

                    <?php if ($item['icon_align'] == 'right') : ?>
                    <span uk-icon="<?= $item['icon'] ?>"></span>
                    <?php endif ?>

                <?php else : ?>
                <?= $item['content'] ?>
                <?php endif ?>

            </a>

            <?php if ($lightbox && $item['link_target'] == 'modal') : ?>
            <?php // uk-flex-top is needed to make vertical margin work for IE11 ?>
            <div id="<?= $connect_id ?>" class="uk-flex-top" uk-modal>
                <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
                    <button class="uk-modal-close-outside" type="button" uk-close></button>
                    <?= $lightbox ?>
                </div>
            </div>
            <?php endif ?>

        <?php if (count($element) > 1) : ?>
        </div>
        <?php endif ?>

    <?php endforeach ?>

    <?php if (count($element) > 1) : ?>
    </div>
    <?php endif ?>

</div>
