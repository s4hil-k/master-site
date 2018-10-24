<?php

return [

    'name' => 'yootheme/settings',

    'inject' => [

        'styles' => 'app.styles',
        'scripts' => 'app.scripts',
        'customizer' => 'theme.customizer',

    ],

    'events' => [

        'theme.init' => function ($theme) {

            // set defaults
            $theme->merge($this->options['config']['defaults'], true);
        },

        'theme.admin' => function ($theme) {

            // add script
            $this->scripts->add('customizer-about', "{$this->path}/app/about.min.js", 'customizer');
        },

        'theme.site' => [function ($theme) {

            // set config
            $theme->merge([
                'body_class' => [$theme->get('page_class')],
                'favicon' => $this->app->url($theme->get('favicon') ?: '@assets/images/favicon.png'),
                'touchicon' => $this->app->url($theme->get('touchicon') ?: '@assets/images/apple-touch-icon.png'),
            ]);

            // combine assets
            if ($theme->get('compression') && !$this->customizer->isActive()) {
                $this->styles->combine('styles', 'theme-*', ['CssImportResolver', 'CssRewriteUrl']);
                $this->scripts->combine('scripts', '{theme-*,uikit*}');
            }

            // google analytics
            if ($id = $theme->get('google_analytics')) {

                $anon = $theme->get('google_analytics_anonymize') ? "ga('set', 'anonymizeIp', true);" : '';

                $this->scripts
                    ->add('google-analytics', 'https://www.google-analytics.com/analytics.js', [], ['defer' => true])
                    ->add('google-analytics-id', "window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)}; ga.l=+new Date; ga('create','{$id}','auto'); {$anon} ga('send','pageview');", [], 'string');
            }

        }, 5]

    ],

    'routes' => function ($routes) {

        $routes->get('/cache', 'YOOtheme\Theme\CacheController:index');
        $routes->post('/cache/clear', 'YOOtheme\Theme\CacheController:clear');

    },

    'config' => [

        'section' => [
            'title' => 'Settings',
            'priority' => 60
        ],

        'fields' => [],

        'defaults' => []

    ]

];
