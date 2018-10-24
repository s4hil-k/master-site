<?php

return [

    'name' => 'yootheme/builder-html',

    'builder' => 'html',

    'render' => function ($element) {
        return "<div>{$element['content']}</div>";
    },

    'config' => [

        'element' => true,

    ],

    'default' => [

        'props' => [
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        ],

    ],

];
