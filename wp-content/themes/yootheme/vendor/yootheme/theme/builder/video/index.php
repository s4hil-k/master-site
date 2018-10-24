<?php

return [

    'name' => 'yootheme/builder-video',

    'builder' => 'video',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {

        if (empty($element['video'])) {
            $element['video_poster'] = $this->app->url('@assets/images/element-video-placeholder.png');
        }

        return $this->view->render('@builder/video/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'video_controls' => true,

            'margin' => 'default',

        ],

    ],

];
