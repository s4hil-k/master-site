<?php

return [

    'name' => 'yootheme/builder-divider',

    'builder' => 'divider',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/divider/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'divider_element' => 'hr',

        ],

    ],

];
