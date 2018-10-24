<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\EventSubscriber;
use YOOtheme\Theme\Customizer;

class CustomizerListener extends EventSubscriber
{
    public $active = false;
    public $inject = [
        'styles' => 'app.styles',
        'scripts' => 'app.scripts',
        'customizer' => 'theme.customizer',
    ];

    public function onInit()
    {
        add_action('customize_register', function ($customizer) {

            // set active
            $this->active = true;

            // add settings
            $customizer->add_setting('config');
            $customizer->add_setting('page');
            $customizer->remove_setting('site_icon');

            // encode config
            add_filter('customize_sanitize_js_config', function ($value) {
                return base64_encode($this->theme->config->json());
            });

            // decode config
            add_filter('customize_sanitize_config', function ($value) {
                return base64_decode($value);
            });

            // decode page
            add_filter('customize_sanitize_page', function ($value) {
                return json_decode(base64_decode($value), true);
            });

            // remove page
            add_action('customize_save', function ($customizer) {
                $customizer->remove_setting('page');
            });

        }, 10);

        $this->theme['customizer'] = function () {
            return new Customizer($this->active);
        };
    }

    public function onSite()
    {
        // is active?
        if (!$this->customizer->isActive()) {
            return;
        }

        // add assets
        $this->styles->add('customizer', 'platforms/wordpress/assets/css/site.css', 'theme-style');
    }

    public function onAdmin()
    {
        // add assets
        $this->styles->add('customizer', 'platforms/wordpress/assets/css/admin.css');
        $this->scripts->add('customizer', 'platforms/wordpress/app/customizer.min.js', ['uikit', 'commons', 'app-config']);
    }

    public function onView()
    {
        // add data
        if ($this->customizer->isActive() && $data = $this->customizer->getData()) {
            $this->scripts->add('customizer-data', sprintf('var $customizer = %s;', json_encode($data)), 'customizer', 'string');
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'init' => 'onInit',
            'view' => 'onView',
            'theme.site' => ['onSite', 15],
            'theme.admin' => 'onAdmin',
        ];
    }
}
