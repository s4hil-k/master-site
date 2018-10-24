<?php

return [

    // module name
    'name' => 'yootheme/nativerank-article-start',

    // how this element is referenced inside the builder
    'builder' => 'nativerank_article_start',

    // render this element on the website
    'render' => function ($element) {
        return $this->app->view->render("{$this->path}/template.php", ['element' => $element]);
    },

    'events' => [

        // Register the element in the builder
        'builder.init' => function ($elements, $builder) {
            $elements->set('nativerank_article_start', json_decode(file_get_contents("{$this->path}/nativerank-article-start.json"), true));
        }


    ],

    'config' => [

        'element' => true

    ]

];
