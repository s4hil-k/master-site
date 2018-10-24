<?php

return [

    'name' => 'yootheme/builder-subnav',

    'builder' => 'subnav',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/subnav/template', compact('element'));
    },

    'config' => [

        'element' => true,

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'subnav_item',
        ])

    ],

    'include' => [

        'yootheme/builder-subnav-item' => [

            'builder' => 'subnav_item',

            'default' => [

                'props' => [
                    'content' => 'Item',
                ],

            ],

        ],

    ],

];
