<?php

return [

    'name' => 'yootheme/builder-grid',

    'builder' => 'grid',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {

        // Deprecated
        if ($element['grid_parallax'] === null && $element['grid_mode'] == 'parallax' && $element['grid_parallax_y']) {
            $element['grid_parallax'] = $element['grid_parallax_y'];
        }

        // Deprecated
        if ($element['title_element'] === null) {
            $element['title_element'] = 'h3';
        }

        return $this->view->render('@builder/grid/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'show_title' => true,
            'show_meta' => true,
            'show_content' => true,
            'show_image' => true,
            'show_link' => true,

            'grid_default' => '1',
            'grid_medium' => '3',

            'filter_style' => 'tab',
            'filter_all' => true,
            'filter_position' => 'top',
            'filter_align' => 'left',
            'filter_grid_width' => 'auto',
            'filter_breakpoint' => 'm',

            'title_element' => 'h3',
            'meta_style' => 'meta',
            'meta_align' => 'bottom',
            'icon_ratio' => 4,
            'image_align' => 'top',
            'image_grid_width' => '1-2',
            'image_breakpoint' => 'm',
            'link_text' => 'Read more',
            'link_style' => 'default',

            'margin' => 'default',

            'item_animation' => '',

        ],

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'grid_item',
        ])

    ],

    'include' => [

        'yootheme/builder-grid-item' => [

            'builder' => 'grid_item',

            'default' => [

                'props' => [
                    'title' => 'Panel',
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                ],

            ],

        ],

    ],

];
