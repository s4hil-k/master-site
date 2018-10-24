<?php

return [

    'name' => 'yootheme/builder-countdown',

    'builder' => 'countdown',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/countdown/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'show_separator' => true,
            'show_label' => true,
            'gutter' => 'small',
            'label_margin' => 'small',
            'margin' => 'default',

        ],

    ],

    'default' => [

        'props' => [
            'date' => null,
        ],

    ],

];
