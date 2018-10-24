<?php

use YOOtheme\Encryption;

return [

    'name' => 'yootheme/builder-newsletter',

    'builder' => 'newsletter',

    'inject' => [

        'view' => 'app.view',
        'scripts' => 'app.scripts',

    ],

    'main' => function () {

        $this['encryption'] = function () {
            return new Encryption($this->app['secret'], $this->app['csrf']->generate());
        };

    },

    'render' => function ($element) {

        $this->scripts->add('newsletter', '@builder/newsletter/app/newsletter.min.js', [], ['defer' => true]);

        $settings = array_merge($element['provider'], $element[$element['provider']['name']]);
        $settings = $this->encryption->encrypt($settings);

        $attrs_form = [
            'action' => $this->app->route('theme/newsletter/subscribe'),
        ];

        return $this->view->render('@builder/newsletter/template', compact('element', 'attrs_form', 'settings'));
    },

    'autoload' => [
        'YOOtheme\\Builder\\Newsletter\\' => 'src',
    ],

    'routes' => function ($route) {

        $providers = [
            'mailchimp' => '\\YOOtheme\\Builder\\Newsletter\\MailChimpProvider',
            'cmonitor' => '\\YOOtheme\\Builder\\Newsletter\\CampaignMonitorProvider',
        ];

        $route->post('theme/newsletter/list', function ($settings, $response) use ($providers) {

            if (!isset($settings['name']) or !$provider = $providers[$settings['name']]) {
                return $response->withJson('Invalid provider', 400);
            }

            $apiKey = $this->theme->config[$settings['name'].'_api'];

            try {
                $return = (new $provider($apiKey))->lists($settings);
            } catch (Exception $e) {
                return $response->withJson($e->getMessage(), 400);
            }

            return $response->withJson($return);
        });

        $route->post('theme/newsletter/subscribe', function ($email, $first_name = '', $last_name = '', $settings, $response) use ($providers) {

            $settings = $this->encryption->decrypt($settings);

            if (!isset($settings['name']) or !$provider = $providers[$settings['name']]) {
                return $response->withJson('Invalid provider', 400);
            }

            $apiKey = $this->theme->config[$settings['name'].'_api'];

            try {
                (new $provider($apiKey))->subscribe($email, compact('first_name', 'last_name'), $settings);
            } catch (Exception $e) {
                return $response->withJson($e->getMessage(), 400);
            }

            $return = [
                'successful' => true,
            ];

            if ($settings['after_submit'] === 'redirect') {
                $return['redirect'] = $settings['redirect'];
            } else {
                $return['message'] = $settings['message'];
            }

            return $response->withJson($return);

        }, [
            'csrf' => false,
            'allowed' => true,
        ]);

    },

    'config' => [

        'element' => true,
        'defaults' => [

            'layout' => 'grid',
            'show_name' => true,
            'label_first_name' => 'First name',
            'label_last_name' => 'Last name',
            'label_email' => 'Email address',
            'label_button' => 'Subscribe',
            'provider' => [
                'name' => 'mailchimp',
                'after_submit' => 'message',
                'message' => 'A confirmation link has been sent to your email address.',
                'redirect' => '',
            ],
            'mailchimp' => [
                'client_id' => '',
                'list_id' => '',
            ],
            'cmonitor' => [
                'client_id' => '',
                'list_id' => '',
            ],

            'button_mode' => 'button',
            'button_style' => 'default',
            'button_icon' => 'mail',
        ],

    ],

];
