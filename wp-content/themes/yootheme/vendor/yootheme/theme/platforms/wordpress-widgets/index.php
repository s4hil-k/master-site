<?php

$config = [

    'name' => 'yootheme/wordpress-widgets',

    'main' => 'YOOtheme\\Theme\\Widgets',

    'inject' => [

        'view' => 'app.view',
        'scripts' => 'app.scripts',

    ],

    'events' => [

        'init' => function () {

            add_action('widgets_init', function () {
                require("{$this->path}/src/BuilderWidget.php");
                register_widget('BuilderWidget');
            });

        }

    ],

    'config' => [

        'fields' => [

            'showtitle' => [
                'label' => 'Title',
                'type' => 'select',
                'default' => 0,
                'options' => [
                    'Show' => 1,
                    'Hide' => 0
                ],
            ],

            'class' => [
                'label' => 'Class',
            ],

        ],

        'defaults' => [],

    ],

];

return defined('WPINC') ? $config : false;
