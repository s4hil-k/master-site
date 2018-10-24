<?php

return [

    'name' => 'yootheme/builder-totop',

    'builder' => 'totop',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/totop/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'margin' => 'default',

        ],

    ],

];
