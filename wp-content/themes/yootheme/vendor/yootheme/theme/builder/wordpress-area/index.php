<?php

$config = [

    'name' => 'yootheme/builder-wordpress-area',

    'builder' => 'wordpress_area',

    'inject' => [

        'view' => 'app.view',
        'scripts' => 'app.scripts',

    ],

    'render' => function ($element) {
        return $element['content'] && is_active_sidebar((string) $element['content'])
            ? $this->view->render('@builder/wordpress-area/template', compact('element'))
            : '';
    },

    'events' => [

        'builder.init' => function ($elements, $builder) {
            $elements->set('wordpress_area', json_decode(file_get_contents("{$this->path}/wordpress-area.json"), true));
        }

    ],

    'config' => [

        'element' => true,
        'defaults' => [

            'layout' => 'stack',
            'breakpoint' => 'm',

        ],

    ],

];

return defined('WPINC') ? $config : false;
