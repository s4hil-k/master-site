<?php

return [

    'name' => 'yootheme/builder-icon',

    'builder' => 'icon',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/icon/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'icon' => 'star',
            'icon_ratio' => 3,
            'margin' => 'default',

        ],

    ],

];
