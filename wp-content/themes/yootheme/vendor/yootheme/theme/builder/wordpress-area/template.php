<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];

$layout = $element['layout'] == 'stack' ? 'grid-stack' : 'grid';

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php dynamic_sidebar($element . ":{$layout}") ?>

</div>
