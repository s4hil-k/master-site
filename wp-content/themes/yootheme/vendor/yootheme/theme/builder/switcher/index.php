<?php

return [

    'name' => 'yootheme/builder-switcher',

    'builder' => 'switcher',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {

        // Deprecated
        if ($element['switcher_style'] == 'thumbnail') {
            $element['switcher_style'] = 'thumbnav';
        }

        return $this->view->render('@builder/switcher/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'show_title' => true,
            'show_meta' => true,
            'show_content' => true,
            'show_image' => true,
            'show_link' => true,
            'show_label' => true,
            'show_thumbnail' => true,

            'switcher_style' => 'tab',
            'switcher_position' => 'top',
            'switcher_align' => 'left',
            'switcher_grid_width' => 'auto',
            'switcher_breakpoint' => 'm',
            'switcher_animation' => 'fade',
            'switcher_height' => true,

            'title_element' => 'h3',
            'meta_style' => 'meta',
            'meta_align' => 'bottom',
            'image_align' => 'top',
            'image_grid_width' => '1-2',
            'image_breakpoint' => 'm',
            'switcher_thumbnail_width' => '100',
            'switcher_thumbnail_height' => '75',
            'link_text' => 'Read more',
            'link_style' => 'default',

            'margin' => 'default',

        ],

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'switcher_item',
        ])

    ],

    'include' => [

        'yootheme/builder-switcher-item' => [

            'builder' => 'switcher_item',

            'default' => [

                'props' => [
                    'title' => 'Item',
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                ],

            ],
        ],

    ],

];
