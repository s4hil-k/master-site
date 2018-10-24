<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];

// Accordion
$attrs['uk-accordion'] = $element->pick(['multiple', 'collapsible'])->json();

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php foreach ($element as $item) : ?>
    <div class="el-item">

        <a class="el-title uk-accordion-title" href="#"><?= $item['title'] ?></a>

        <div class="uk-accordion-content">
            <?= $this->render('@builder/accordion/template-item', compact('item')) ?>
        </div>

    </div>
    <?php endforeach ?>

</div>
