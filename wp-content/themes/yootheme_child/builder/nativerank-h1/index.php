<?php

return [

    // module name
    'name' => 'yootheme/nativerank-h1',

    // how this element is referenced inside the builder
    'builder' => 'nativerank_h1',

    // render this element on the website
    'render' => function ($element) {
        return $this->app->view->render("{$this->path}/template.php", ['element' => $element]);
    },

    'events' => [

        // Register the element in the builder
        'builder.init' => function ($elements, $builder) {
            $elements->set('nativerank_h1', json_decode(file_get_contents("{$this->path}/nativerank-h1.json"), true));
        }


    ],

    'config' => [

        'element' => true

    ]

];
