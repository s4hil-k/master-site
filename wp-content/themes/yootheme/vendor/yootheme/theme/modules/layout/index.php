<?php

return [

    'name' => 'yootheme/layout',

    'inject' => [

        'scripts' => 'app.scripts',

    ],

    'events' => [

        'theme.init' => function ($theme) {

            // set defaults
            $theme->merge($this->options['config']['defaults'], true);
        }

    ],

    'config' => [

        'section' => [
            'title' => 'Layout',
            'priority' => 10
        ],

        'fields' => [],

        'defaults' => [

            'menu' => [

                'items' => [],
                'positions' => [],

            ]

        ]

    ]

];
