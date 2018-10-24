<?php

return [

    // module name
    'name' => 'yootheme/nativerank-aside-end',

    // how this element is referenced inside the builder
    'builder' => 'nativerank_aside_end',

    // render this element on the website
    'render' => function ($element) {
        return $this->app->view->render("{$this->path}/template.php", ['element' => $element]);
    },

    'events' => [

        // Register the element in the builder
        'builder.init' => function ($elements, $builder) {
            $elements->set('nativerank_aside_end', json_decode(file_get_contents("{$this->path}/nativerank-aside-end.json"), true));
        }


    ],

    'config' => [

        'element' => true

    ]

];
