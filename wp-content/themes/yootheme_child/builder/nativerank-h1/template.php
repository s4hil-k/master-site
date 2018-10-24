<div class="nr-h1-container">
    <?php


    //the_title('<h1 class="nr-h1">', '</h1>');

    $key_name = get_post_custom_values($key = 'NR - H1');
    $class = "";
    if($element['add_class'])
    {$class = $element['add_class'];}
?>


	<h1 class='hentry-title<?= " ".$class; ?>'><?= $key_name[0]; ?></h1>

</div>

