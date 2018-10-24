<?php

return [

    // module name
    'name' => 'yootheme/nativerank-aside-start',

    // how this element is referenced inside the builder
    'builder' => 'nativerank_aside_start',

    // render this element on the website
    'render' => function ($element) {
        return $this->app->view->render("{$this->path}/template.php", ['element' => $element]);
    },

    'events' => [

        // Register the element in the builder
        'builder.init' => function ($elements, $builder) {
            $elements->set('nativerank_aside_start', json_decode(file_get_contents("{$this->path}/nativerank-aside-start.json"), true));
        }


    ],

    'config' => [

        'element' => true

    ]

];
