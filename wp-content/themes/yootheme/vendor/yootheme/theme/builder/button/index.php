<?php

return [

    'name' => 'yootheme/builder-button',

    'builder' => 'button',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {

        foreach ($element as $child) {

            // Deprecated
            if ($child['link_target'] === true) {
                $child['link_target'] = 'blank';
            }

        }

        return $this->view->render('@builder/button/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'gutter' => 'small',
            'margin' => 'default',

        ],

    ],

    'default' => [

        'children' => [
            [
                'type' => 'button_item',
                'props' => [
                    'content' => 'Button',
                    'button_style' => 'default',
                ],
            ],
        ],

    ],

    'include' => [

        'yootheme/button-item' => [

            'builder' => 'button_item',

            'config' => [

                'defaults' => [

                    'button_style' => 'default',
                    'icon_align'   => 'left'

                ],

            ],

            'default' => [

                'props' => [
                    'content' => 'Button'
                ],

            ],

        ],

    ],

];
