<?php

return [

    'name' => 'yootheme/styler',

    'main' => 'YOOtheme\\Theme\\Styler',

    'routes' => function ($routes) {

        $routes->get('/theme/styles', 'YOOtheme\Theme\StyleController:index');
        $routes->post('/theme/styles', 'YOOtheme\Theme\StyleController:save');

    },

    'config' => [

        'section' => [
            'title' => 'Style',
            'width' => 350,
            'priority' => 11
        ],

        'fields' => [],

        'defaults' => [

            'custom_less' => '',
            'less' => []

        ]

    ]

];
