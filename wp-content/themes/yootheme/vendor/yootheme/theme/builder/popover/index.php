<?php

return [

    'name' => 'yootheme/builder-popover',

    'builder' => 'popover',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {

        if (empty($element['background_image'])) {
            $element['background_image'] = $this->app->url('@assets/images/element-image-placeholder.png');
        }

        return $this->view->render('@builder/popover/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'show_title' => true,
            'show_meta' => true,
            'show_content' => true,
            'show_image' => true,
            'show_link' => true,

            'icon' => 'plus',
            'drop_mode' => 'hover',
            'drop_position' => 'top-center',
            'card_style' => 'default',

            'title_element' => 'h3',
            'meta_style' => 'meta',
            'meta_align' => 'bottom',
            'image_card' => true,
            'link_text' => 'Read more',
            'link_style' => 'default',

            'margin' => 'default',

        ],

    ],

    'default' => [

        'children' => [
            [
                'type' => 'popover_item',
                'props' => [
                    'position_x' => 20,
                    'position_y' => 50,
                    'title' => 'Item',
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                ],
            ],

            [
                'type' => 'popover_item',
                'props' => [
                    'position_x' => 50,
                    'position_y' => 20,
                    'title' => 'Item',
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                ],
            ],

            [
                'type' => 'popover_item',
                'props' => [
                    'position_x' => 70,
                    'position_y' => 70,
                    'title' => 'Item',
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                ],
            ],
        ],

    ],

    'include' => [

        'yootheme/builder-popover-item' => [

            'builder' => 'popover_item',

            'default' => [

                'props' => [
                    'position_x' => 50,
                    'position_y' => 50,
                    'title' => 'Item',
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                ],

            ],

        ],

    ],

];