<?php

return [

    'name' => 'yootheme/builder-row',

    'builder' => 'row',

    'inject' => [

        'view' => 'app.view',
        'scripts' => 'app.scripts',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/row/template', compact('element'));
    },

    'config' => [

        'defaults' => [

            'fixed_width' => 'large',
            'breakpoint' => 'm',

        ],

    ],

];
