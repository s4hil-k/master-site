<?php

return [

    'name' => 'yootheme/builder-text',

    'builder' => 'text',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/text/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'column_breakpoint' => 'm',
            'margin' => 'default',

        ],

    ],

    'default' => [

        'props' => [
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        ],

    ],

];
