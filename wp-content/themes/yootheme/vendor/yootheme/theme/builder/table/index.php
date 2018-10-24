<?php

return [

    'name' => 'yootheme/builder-table',

    'builder' => 'table',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/table/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'show_title' => true,
            'show_meta' => true,
            'show_content' => true,
            'show_image' => true,
            'show_link' => true,

            'table_order' => '1',
            'table_responsive' => 'overflow',
            'table_width_title' => 'shrink',
            'table_width_meta' => 'shrink',

            'meta_style' => 'meta',
            'link_text' => 'Read more',
            'link_style' => 'default',

        ],

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'table_item',
        ]),

    ],

    'include' => [

        'yootheme/builder-table-item' => [

            'builder' => 'table_item',

            'default' => [

                'props' => [
                    'content' => 'Lorem ipsum dolor sit amet.',
                    'title' => 'Item',
                ],

            ],

        ],

    ],

];
