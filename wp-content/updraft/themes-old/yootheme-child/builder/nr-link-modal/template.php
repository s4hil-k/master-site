<?php

$attrs_button['class'] = $element['class'];


$attrs_button['class'][] = 'uk-button';

$attrs_button['class'][] = 'uk-button-'.$element['style'];

$attrs_button['id'] = $element['id'];

$attrs_button['uk-toggle'] = "target: #".$element['unique_id'];

$attrs_button['type'] = 'button';

//modal panel attributes

$attrs_body['uk-modal'] = true;
$attrs_body['id'] = $element['unique_id'];
$attrs_body['class'] = 'uk-modal-container';

?>

<button <?= $this->attrs($attrs_button) ?> > <?= $element['field_content'] ?></button>


<div <?= $this->attrs($attrs_body) ?> >
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-body">
         <?=  $element['body'] ?>
        </div>
    </div>
</div>