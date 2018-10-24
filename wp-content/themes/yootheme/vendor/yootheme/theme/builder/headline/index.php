<?php

return [

    'name' => 'yootheme/builder-headline',

    'builder' => 'headline',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/headline/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'title_element' => 'h1',

        ],

    ],

    'default' => [

        'props' => [
            'content' => 'Headline',
        ],

    ],

];
