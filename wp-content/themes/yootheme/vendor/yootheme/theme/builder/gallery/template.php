<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$tags  = [];
$attrs_grid = [];
$attrs_grid_cell = [];
$attrs_filter_grid = [];
$attrs_filter_cell_nav = [];

// Grid
$options = [];
$options[] = $element['grid_masonry'] ? 'masonry: true' : '';
$options[] = $element['grid_parallax'] ? "parallax: {$element['grid_parallax']}" : '';
$attrs_grid['uk-grid'] = implode(';', array_filter($options)) ?: true;

// Filter
$filterTags = function ($item) {

    $tags = array_filter(array_map('trim', explode(',', $item['tags'])));

    return array_combine(
        $tags,
        array_map(
            function ($tag) {
                return str_replace(' ', '-', $tag);
            },
            $tags
        )
    );
};

if ($element['filter']) {

    $tags = array_unique(call_user_func_array('array_replace', array_map($filterTags, $element->children)));
    natsort($tags);

    if ($tags) {
        $attrs['uk-filter'] = '.js-filter';
        $attrs_grid['class'][] = 'js-filter';
    }

    // Filter Alignment
    $attrs_filter_grid['class'][] = 'uk-child-width-expand';
    $attrs_filter_grid['class'][] = $element['filter_gutter'] ? "uk-grid-{$element['filter_gutter']}" : '';
    $attrs_filter_grid['uk-grid'] = true;

    $attrs_filter_cell_nav['class'][] = "uk-width-{$element['filter_grid_width']}@{$element['filter_breakpoint']}";
    $attrs_filter_cell_nav['class'][] = $element['filter_position'] == 'right' ? "uk-flex-last@{$element['filter_breakpoint']}" : '';

}

// Grid Columns
$attrs_grid['class'][] = "uk-child-width-1-{$element['grid_default']}";

$attrs_grid['class'][] = $element['grid_small'] ? "uk-child-width-1-{$element['grid_small']}@s" : '';
$attrs_grid['class'][] = $element['grid_medium'] ? "uk-child-width-1-{$element['grid_medium']}@m" : '';
$attrs_grid['class'][] = $element['grid_large'] ? "uk-child-width-1-{$element['grid_large']}@l" : '';
$attrs_grid['class'][] = $element['grid_xlarge'] ? "uk-child-width-1-{$element['grid_xlarge']}@xl" : '';

$attrs_grid['class'][] = $element['gutter'] ? "uk-grid-{$element['gutter']}" : '';
$attrs_grid['class'][] = $element['divider'] ? 'uk-grid-divider' : '';

// Lightbox
$attrs_grid['uk-lightbox'] = $element['lightbox'] ? 'toggle: a[data-type]' : false;

// Orientation
$attrs_grid_cell['class'][] = $element['image_orientation'] ? 'uk-flex uk-flex-center uk-flex-middle' : '';

?>

<?php if ($tags) : ?>
<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php if (in_array($element['filter_position'], ['left', 'right'])) : ?>
    <div<?= $this->attrs($attrs_filter_grid) ?>>
        <div<?= $this->attrs($attrs_filter_cell_nav) ?>>
    <?php endif ?>

            <?= $this->render('@builder/gallery/template-nav', compact('item', 'tags')) ?>

    <?php if (in_array($element['filter_position'], ['left', 'right'])) : ?>
        </div>
        <div>
    <?php endif ?>

            <div<?= $this->attrs($attrs_grid) ?>>

                <?php foreach ($element as $item) : ?>
                <div<?= $this->attrs($attrs_grid_cell, ['data-tag' => $filterTags($item)]) ?>>
                    <?= $this->render('@builder/gallery/template-item', compact('item')) ?>
                </div>
                <?php endforeach ?>

            </div>

    <?php if (in_array($element['filter_position'], ['left', 'right'])) : ?>
        </div>
    </div>
    <?php endif ?>

</div>
<?php else : ?>
<div<?= $this->attrs(compact('id', 'class'), $attrs, $attrs_grid) ?>>

    <?php foreach ($element as $item) : ?>
    <div<?= $this->attrs($attrs_grid_cell) ?>><?= $this->render('@builder/gallery/template-item', compact('item')) ?></div>
    <?php endforeach ?>

</div>
<?php endif ?>
