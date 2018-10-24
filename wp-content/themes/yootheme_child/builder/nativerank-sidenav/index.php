<?php

return [

    // Module name
    'name' => 'yootheme/nativerank-sidenav',

    // How this element is referenced inside the builder
    'builder' => 'nativerank_sidenav',

    // Render this element on the website
    'render' => function ($element) {
        return $this->app->view->render("{$this->path}/template.php", ['element' => $element]);
    },

    'events' => [

        'builder.init' => function ($elements, $builder) {
            $elements->set('nativerank_sidenav', json_decode(file_get_contents("{$this->path}/nativerank_sidenav.json"), true));
        }

    ],

    'config' => [

        'element' => true

    ]

];
