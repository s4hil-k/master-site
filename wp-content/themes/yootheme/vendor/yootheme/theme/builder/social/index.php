<?php

return [

    'name' => 'yootheme/builder-social',

    'builder' => 'social',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/social/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'link_style' => 'button',
            'gutter' => 'small',
            'margin' => 'default',

        ]

    ],

    'default' => [

        'props' => [

            'links' => [
                'https://twitter.com',
                'https://facebook.com',
                'https://plus.google.com',
            ]

        ]

    ],

];
