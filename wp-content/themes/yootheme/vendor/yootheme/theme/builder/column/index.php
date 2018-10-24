<?php

return [

    'name' => 'yootheme/builder-column',

    'builder' => 'column',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/column/template', compact('element'));
    },

    'config' => [

       'defaults' => [

            'image_position' => 'center-center',

        ],

    ],

];
