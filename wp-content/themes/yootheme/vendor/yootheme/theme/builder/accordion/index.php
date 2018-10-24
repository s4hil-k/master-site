<?php

return [

    'name' => 'yootheme/builder-accordion',

    'builder' => 'accordion',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/accordion/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'show_image' => true,
            'show_link' => true,
            'collapsible' => true,
            'image_align' => 'top',
            'image_grid_width' => '1-2',
            'image_breakpoint' => 'm',
            'link_text' => 'Read more',
            'link_style' => 'default',

        ],

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'accordion_item',
        ]),

    ],

    'include' => [

        'yootheme/builder-accordion-item' => [

            'builder' => 'accordion_item',

            'default' => [

                'props' => [
                    'title' => 'Item',
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                ],

            ],

        ],

    ],

];
