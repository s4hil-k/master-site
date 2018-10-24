<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_table = [];
$attrs_cell_title = [];
$attrs_cell_meta = [];
$attrs_cell_content = [];
$attrs_cell_image = [];
$attrs_cell_link = [];

// Find empty fields
$title_empty = true;
$meta_empty = true;
$content_empty = true;
$image_empty = true;
$link_empty = true;

foreach ($element as $item) {
    if ($item['title']) { $title_empty = false; }
    if ($item['meta']) { $meta_empty = false; }
    if ($item['content']) { $content_empty = false; }
    if ($item['image']) { $image_empty = false; }
    if ($item['link']) { $link_empty = false; }
}

if ($title_empty) { $element['show_title'] = false; }
if ($meta_empty) { $element['show_meta'] = false; }
if ($content_empty) { $element['show_content'] = false; }
if ($image_empty) { $element['show_image'] = false; }
if ($link_empty) { $element['show_link'] = false; }

// Style
$attrs_table['class'][] = $element['table_style'] ? "uk-table uk-table-{$element['table_style']}" : 'uk-table';
$attrs_table['class'][] = $element['table_hover'] ? 'uk-table-hover' : '';
$attrs_table['class'][] = $element['table_justify'] ? 'uk-table-justify' : '';

// Size
$attrs_table['class'][] = $element['table_size'] ? "uk-table-{$element['table_size']}" : '';

// Vertical align
$attrs_table['class'][] = $element['table_vertical_align'] ? 'uk-table-middle' : '';

// Responsive
$attrs_table['class'][] = $element['table_responsive'] == 'responsive' ? 'uk-table-responsive' : '';
$class[] = $element['table_responsive'] == 'overflow' ? 'uk-overflow-auto' : '';

// Text wrap
$attrs_cell_title['class'][] = $element['table_width_title'] == 'shrink' ? 'uk-text-nowrap' : '';
$attrs_cell_meta['class'][] = $element['table_width_meta'] == 'shrink' ? 'uk-text-nowrap' : '';
$attrs_cell_content['class'][] = $element['table_width_content'] == 'shrink' ? 'uk-text-nowrap' : '';
$attrs_cell_link['class'][] = 'uk-text-nowrap';

// Last column alignment
if ($element['table_last_align']) {

    $breakpoint = $element['table_responsive'] == 'responsive' ? '@m' : '';

    switch ($element['table_order']) {
        case 1:
            if ($element['show_link']) {
                $attrs_cell_link['class'][] = "uk-text-{$element['table_last_align']}{$breakpoint}";
            } elseif ($element['show_content']) {
                $attrs_cell_content['class'][] = "uk-text-{$element['table_last_align']}{$breakpoint}";
            } else {
                $attrs_cell_title['class'][] = "uk-text-{$element['table_last_align']}{$breakpoint}";
            }
            break;
        case 3:
            if ($element['show_link']) {
                $attrs_cell_link['class'][] = "uk-text-{$element['table_last_align']}{$breakpoint}";
            } elseif ($element['show_meta']) {
                $attrs_cell_meta['class'][] = "uk-text-{$element['table_last_align']}{$breakpoint}";
            } else {
                $attrs_cell_content['class'][] = "uk-text-{$element['table_last_align']}{$breakpoint}";
            }
            break;
        case 2:
        case 4:
            if ($element['show_link']) {
                $attrs_cell_link['class'][] = "uk-text-{$element['table_last_align']}{$breakpoint}";
            } elseif ($element['show_content']) {
                $attrs_cell_content['class'][] = "uk-text-{$element['table_last_align']}{$breakpoint}";
            } else {
                $attrs_cell_meta['class'][] = "uk-text-{$element['table_last_align']}{$breakpoint}";
            }
            break;
        case 5:
        case 6:
            if ($element['show_image']) {
                $attrs_cell_image['class'][] = "uk-text-{$element['table_last_align']}{$breakpoint}";
            } elseif ($element['show_link']) {
                $attrs_cell_link['class'][] = "uk-text-{$element['table_last_align']}{$breakpoint}";
            } else {
                $attrs_cell_content['class'][] = "uk-text-{$element['table_last_align']}{$breakpoint}";
            }
            break;
    }
}

?>

<?php if ($element['table_responsive'] == 'overflow') : ?>
<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>
    <table<?= $this->attrs($attrs_table) ?>>
<?php else : ?>
    <table<?= $this->attrs(compact('id', 'class'), $attrs, $attrs_table) ?>>
<?php endif ?>

        <?php if ($element['table_head_title'] ||
                  $element['table_head_meta'] ||
                  $element['table_head_content'] ||
                  $element['table_head_image'] ||
                  $element['table_head_link']) : ?>

            <?php

                // Templates
                $element['table_head_meta'] = $element['show_meta'] ? "<th{$this->attrs($attrs_cell_meta)}>{$element['table_head_meta']}</th>" : '';
                $element['table_head_image'] = $element['show_image'] ? "<th{$this->attrs($attrs_cell_image)}>{$element['table_head_image']}</th>" : '';
                $element['table_head_title'] = $element['show_title'] ? "<th{$this->attrs($attrs_cell_title)}>{$element['table_head_title']}</th>" : '';
                $element['table_head_content'] = $element['show_content'] ? "<th{$this->attrs($attrs_cell_content)}>{$element['table_head_content']}</th>" : '';
                $element['table_head_link'] = $element['show_link'] ? "<th{$this->attrs($attrs_cell_link)}>{$element['table_head_link']}</th>" : '';

            ?>

        <thead>
            <tr>

                <?php if ($element['table_order'] == '1') : ?>

                    <?= $element['table_head_meta'] ?>
                    <?= $element['table_head_image'] ?>
                    <?= $element['table_head_title'] ?>
                    <?= $element['table_head_content'] ?>
                    <?= $element['table_head_link'] ?>

                <?php elseif ($element['table_order'] == '2') : ?>

                    <?= $element['table_head_title'] ?>
                    <?= $element['table_head_image'] ?>
                    <?= $element['table_head_meta'] ?>
                    <?= $element['table_head_content'] ?>
                    <?= $element['table_head_link'] ?>

                <?php elseif ($element['table_order'] == '3') : ?>

                    <?= $element['table_head_image'] ?>
                    <?= $element['table_head_title'] ?>
                    <?= $element['table_head_content'] ?>
                    <?= $element['table_head_meta'] ?>
                    <?= $element['table_head_link'] ?>

                <?php elseif ($element['table_order'] == '4') : ?>

                    <?= $element['table_head_image'] ?>
                    <?= $element['table_head_title'] ?>
                    <?= $element['table_head_meta'] ?>
                    <?= $element['table_head_content'] ?>
                    <?= $element['table_head_link'] ?>

                <?php elseif ($element['table_order'] == '5') : ?>

                    <?= $element['table_head_title'] ?>
                    <?= $element['table_head_meta'] ?>
                    <?= $element['table_head_content'] ?>
                    <?= $element['table_head_link'] ?>
                    <?= $element['table_head_image'] ?>

                <?php elseif ($element['table_order'] == '6') : ?>

                    <?= $element['table_head_meta'] ?>
                    <?= $element['table_head_title'] ?>
                    <?= $element['table_head_content'] ?>
                    <?= $element['table_head_link'] ?>
                    <?= $element['table_head_image'] ?>

                <?php endif ?>

            </tr>
        </thead>
        <?php endif ?>

        <tbody>
        <?php $first = true; ?>
        <?php foreach ($element as $item) : ?>

            <?php

                // Display
                if (!$element['show_title']) { $item['title'] = ''; }
                if (!$element['show_meta']) { $item['meta'] = ''; }
                if (!$element['show_content']) { $item['content'] = ''; }
                if (!$element['show_image']) { $item['image'] = ''; }
                if (!$element['show_link']) { $item['link'] = ''; }

                // Widths
                $attrs_width_title = [];
                $attrs_width_meta = [];
                $attrs_width_content = [];
                $attrs_width_image = [];
                $attrs_width_link = [];

                if ($first) {

                    switch ($element['table_width_title']) {
                        case '':
                            break;
                        case 'shrink':
                            $attrs_width_title['class'][] = "uk-table-{$element['table_width_title']}";
                            break;
                        default:
                            $attrs_width_title['class'][] = "uk-width-{$element['table_width_title']}";
                    }

                    switch ($element['table_width_meta']) {
                        case '':
                            break;
                        case 'shrink':
                            $attrs_width_meta['class'][] = "uk-table-{$element['table_width_meta']}";
                            break;
                        default:
                            $attrs_width_meta['class'][] = "uk-width-{$element['table_width_meta']}";
                    }

                    switch ($element['table_width_content']) {
                        case '':
                            break;
                        case 'shrink':
                            $attrs_width_content['class'][] = "uk-table-{$element['table_width_content']}";
                            break;
                        default:
                            $attrs_width_content['class'][] = "uk-width-{$element['table_width_content']}";
                    }

                    $attrs_width_image['class'][] = 'uk-table-shrink';
                    $attrs_width_link['class'][] = 'uk-table-shrink';
                }

                // Templates
                if ($element['show_title']) {
                    $item['title'] = "<td{$this->attrs($attrs_cell_title, $attrs_width_title)}>{$this->render('@builder/table/template-title', compact('item'))}</td>";
                }

                if ($element['show_meta']) {
                    $item['meta'] = "<td{$this->attrs($attrs_cell_meta, $attrs_width_meta)}>{$this->render('@builder/table/template-meta', compact('item'))}</td>";
                }

                if ($element['show_content']) {
                    $item['content'] = "<td{$this->attrs($attrs_cell_content, $attrs_width_content)}>{$this->render('@builder/table/template-content', compact('item'))}</td>";
                }

                if ($element['show_image']) {
                    $item['image'] = "<td{$this->attrs($attrs_cell_image, $attrs_width_image)}>{$this->render('@builder/table/template-image', compact('item'))}</td>";
                }

                if ($element['show_link']) {
                    $item['link'] = "<td{$this->attrs($attrs_cell_link, $attrs_width_link)}>{$this->render('@builder/table/template-link', compact('item'))}</td>";
                }

            ?>

            <tr class="el-item">

                <?php if ($element['table_order'] == '1') : ?>

                    <?= $item['meta'] ?>
                    <?= $item['image'] ?>
                    <?= $item['title'] ?>
                    <?= $item['content'] ?>
                    <?= $item['link'] ?>

                <?php elseif ($element['table_order'] == '2') : ?>

                    <?= $item['title'] ?>
                    <?= $item['image'] ?>
                    <?= $item['meta'] ?>
                    <?= $item['content'] ?>
                    <?= $item['link'] ?>

                <?php elseif ($element['table_order'] == '3') : ?>

                    <?= $item['image'] ?>
                    <?= $item['title'] ?>
                    <?= $item['content'] ?>
                    <?= $item['meta'] ?>
                    <?= $item['link'] ?>

                <?php elseif ($element['table_order'] == '4') : ?>

                    <?= $item['image'] ?>
                    <?= $item['title'] ?>
                    <?= $item['meta'] ?>
                    <?= $item['content'] ?>
                    <?= $item['link'] ?>

                <?php elseif ($element['table_order'] == '5') : ?>

                    <?= $item['title'] ?>
                    <?= $item['meta'] ?>
                    <?= $item['content'] ?>
                    <?= $item['link'] ?>
                    <?= $item['image'] ?>

                <?php elseif ($element['table_order'] == '6') : ?>

                    <?= $item['meta'] ?>
                    <?= $item['title'] ?>
                    <?= $item['content'] ?>
                    <?= $item['link'] ?>
                    <?= $item['image'] ?>

                <?php endif ?>

            </tr>

            <?php

                if ($first) {
                    $first = false;
                }

            ?>

        <?php endforeach ?>
        </tbody>

    </table>

<?php if ($element['table_responsive'] == 'overflow') : ?>
</div>
<?php endif ?>