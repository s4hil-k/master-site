<?php

$attrs_switcher = [];
$attrs_switcher_nav = [];
$connect_id = 'js-' . substr(uniqid(), -3);

// Swicher
$attrs_switcher['id'][] = $connect_id;
$attrs_switcher['class'][] = 'uk-switcher';

// Switcher nav
$attrs_switcher_nav['uk-switcher'][] = "connect: #{$connect_id}; animation: uk-animation-fade";
$attrs_switcher_nav['class'][] = 'uk-dotnav uk-flex-center uk-margin';

?>

<ul<?= $this->attrs($attrs_switcher) ?>>

    <?php foreach ($element as $item) : ?>
    <li><?= $this->render('@builder/popover/template-item', compact('item')) ?></li>
    <?php endforeach ?>

</ul>

<ul<?= $this->attrs($attrs_switcher_nav) ?>>
    <?php foreach ($element as $item) : ?>
    <li><a href="#"></a></li>
    <?php endforeach ?>
</ul>
