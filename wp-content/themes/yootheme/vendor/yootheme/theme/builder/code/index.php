<?php

return [

    'name' => 'yootheme/builder-code',

    'builder' => 'code',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/code/template', compact('element'));
    },

    'config' => [

        'element' => true,

    ],

    'default' => [

        'props' => [
            'content' => '// Code example
<div id="myid" class="myclass" hidden>
    Lorem ipsum <strong>dolor</strong> sit amet, consectetur adipiscing elit.
</div>'
        ],

    ],

];
