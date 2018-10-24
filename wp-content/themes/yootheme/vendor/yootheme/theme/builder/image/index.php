<?php

return [

    'name' => 'yootheme/builder-image',

    'builder' => 'image',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {

        // Deprecated
        if ($element['link_target'] === true) {
            $element['link_target'] = 'blank';
        }

        if (empty($element['image'])) {
            $element['image'] = $this->app->url('@assets/images/element-image-placeholder.png');
        }

        return $this->view->render('@builder/image/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'margin' => 'default',

        ],

    ],

];
