<?php

$config = [

    'name' => 'yootheme/wordpress',

    'main' => 'YOOtheme\\Wordpress',

    'inject' => [

        'url' => 'app.url',
        'admin' => 'app.admin',
        'styles' => 'app.styles',
        'scripts' => 'app.scripts',

    ],

    'events' => [

        'init' => function ($app) {

            if (isset($app['path.cache']) && !is_dir($app['path.cache']) && !mkdir($app['path.cache'], 0777, true)) {
                throw new \RuntimeException(sprintf('Unable to create cache folder in "%s"', $app['path.cache']));
            }

            add_action($app['admin'] ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts', function () {
                $this->app->trigger('view', [$this->app]);
            });

            add_filter('the_content', function ($content) {
                $this->app->trigger('content', [$content]);
                return $content;
            });

            $handle = function () {
                $this->app->run();
                exit;
            };

            add_action('wp_ajax_kernel', $handle);
            add_action('wp_ajax_nopriv_kernel', $handle);
        }

    ]

];

return defined('WPINC') ? $config : false;
