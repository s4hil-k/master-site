<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_label = [];

// Countdown
$attrs['uk-countdown'] = 'date: '.($element['date'] ? $element['date'] : date('Y-m-d', strtotime('+1 week')));

// Grid
$attrs['uk-grid'] = true;
$class[] = 'uk-child-width-auto';
$class[] = $element['gutter'] ? "uk-grid-{$element['gutter']}" : '';

// Flex alignment
if ($element['text_align'] && $element['text_align_breakpoint']) {
    $class[] = "uk-flex-{$element['text_align']}@{$element['text_align_breakpoint']}";
    if ($element['text_align_fallback']) {
        $class[] = "uk-flex-{$element['text_align_fallback']}";
    }
} else if ($element['text_align']) {
    $class[] = "uk-flex-{$element['text_align']}";
}

// Label
$attrs_label['class'][] = 'uk-countdown-label uk-text-center uk-visible@s';

switch ($element['label_margin']) {
    case '':
        $attrs_label['class'][] = 'uk-margin';
        break;
    default:
        $attrs_label['class'][] = "uk-margin-{$element['label_margin']}";
}

$label_days = $element->get('label_days') ? $element->get('label_days') : 'Days';
$label_hours = $element->get('label_hours') ? $element->get('label_hours') : 'Hours';
$label_minutes = $element->get('label_minutes') ? $element->get('label_minutes') : 'Minutes';
$label_seconds = $element->get('label_seconds') ? $element->get('label_seconds') : 'Seconds';

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>
    <div>

        <div class="uk-countdown-number uk-countdown-days"></div>

        <?php if ($element['show_label']) : ?>
        <div<?= $this->attrs($attrs_label) ?>><?= $label_days ?></div>
        <?php endif ?>

    </div>

    <?php if ($element['show_separator']) : ?>
    <div class="uk-countdown-separator">:</div>
    <?php endif ?>

    <div>

        <div class="uk-countdown-number uk-countdown-hours"></div>

        <?php if ($element['show_label']) : ?>
        <div<?= $this->attrs($attrs_label) ?>><?= $label_hours ?></div>
        <?php endif ?>

    </div>

    <?php if ($element['show_separator']) : ?>
    <div class="uk-countdown-separator">:</div>
    <?php endif ?>

    <div>

        <div class="uk-countdown-number uk-countdown-minutes"></div>

        <?php if ($element['show_label']) : ?>
        <div<?= $this->attrs($attrs_label) ?>><?= $label_minutes ?></div>
        <?php endif ?>

    </div>

    <?php if ($element['show_separator']) : ?>
    <div class="uk-countdown-separator">:</div>
    <?php endif ?>

    <div>

        <div class="uk-countdown-number uk-countdown-seconds"></div>

        <?php if ($element['show_label']) : ?>
        <div<?= $this->attrs($attrs_label) ?>><?= $label_seconds ?></div>
        <?php endif ?>

    </div>
</div>
