<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_grid = [];
$attrs_cell_button = [];
$attrs_input = [];
$attrs_button = [];

// Layout
$attrs_grid['uk-grid'] = true;
$attrs_grid['class'][] = $element['gutter'] ? "uk-grid-{$element['gutter']}" : '';

switch ($element['layout']) {
    case 'grid':
        $attrs_grid['class'][] = 'uk-child-width-expand@s';
        $attrs_cell_button['class'][] = 'uk-width-auto@s';
        break;
    case 'stacked':
    case 'stacked-name':
        $attrs_grid['class'][] = 'uk-child-width-1-1';
        break;
}

// Input
$attrs_input['class'][] = 'uk-input el-input';
$attrs_input['class'][] = $element['form_size'] ? "uk-form-{$element['form_size']}" : '';
$attrs_input['class'][] = $element['form_style'] ? "uk-form-{$element['form_style']}" : '';

// Button
$attrs_button['class'][] = 'el-button';

if ($element['button_mode'] == 'button') {
    $attrs_button['class'][] = "uk-button uk-button-{$element['button_style']}";
    $attrs_button['class'][] = $element['form_size'] && $element['button_style'] != 'text' ? "uk-button-{$element['form_size']}" : '';
    $attrs_button['class'][] = $element['button_fullwidth'] && $element['layout'] != 'grid' ? 'uk-width-1-1' : '';
    if ($element['button_margin'] && $element['show_name']) {
        if ($element['layout'] == "grid") {
            $attrs_button['class'][] = $element['button_margin'] == 'default' ? 'uk-margin-left' : 'uk-margin-small-left';
        } else {
            $attrs_button['class'][] = $element['button_margin'] == 'default' ? 'uk-margin-top' : 'uk-margin-small-top';
        }
    }
} else {
    $attrs_button['class'][] = 'uk-form-icon uk-form-icon-flip';
    $attrs_button['uk-icon'] = $element['button_icon'] ? "icon: {$element['button_icon']}" : false;
}

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <form class="uk-form uk-panel js-form-newsletter" method="post"<?= $this->attrs($attrs_form) ?>>

        <div<?= $this->attrs($attrs_grid) ?>>

            <?php if ($element['show_name']) : ?>

                <?php if ($element['layout'] == 'stacked-name') : ?>
                <div>
                    <div class="uk-child-width-1-2@s <?= $element['gutter'] ? "uk-grid-{$element['gutter']}" : '' ?>" uk-grid>
                <?php endif ?>

                <div><input<?= $this->attrs($attrs_input) ?> name="first_name" placeholder="<?= $element['label_first_name'] ?>"></div>
                <div><input<?= $this->attrs($attrs_input) ?> name="last_name" placeholder="<?= $element['label_last_name'] ?>"></div>

                <?php if ($element['layout'] == 'stacked-name') : ?>
                    </div>
                </div>
                <?php endif ?>

            <?php endif ?>

            <?php if ($element['button_mode'] == 'button') : ?>
            <div><input<?= $this->attrs($attrs_input) ?> type="email" name="email" placeholder="<?= $element['label_email'] ?>" required></div>
            <div<?= $this->attrs($attrs_cell_button) ?>><button<?= $this->attrs($attrs_button) ?> type="submit"><?= $element['label_button'] ?></button></div>
            <?php endif ?>

            <?php if ($element['button_mode'] == 'icon') : ?>
            <div class="uk-position-relative">
                <button<?= $this->attrs($attrs_button) ?> title="<?= $element['label_button'] ?>"></button>
                <input<?= $this->attrs($attrs_input) ?> type="email" name="email" placeholder="<?= $element['label_email'] ?>" required>
            </div>
            <?php endif ?>

        </div>

        <input type="hidden" name="settings" value="<?= $settings ?>">
        <div class="message uk-margin uk-hidden"></div>

    </form>

</div>
