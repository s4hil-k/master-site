<?php

use YOOtheme\Theme\Builder;
use YOOtheme\Theme\ElementRenderer;
use YOOtheme\Util\Arr;
use YOOtheme\Util\Collection;

return [

    'name' => 'yootheme/builder',

    'main' => function ($app) {

        $this['data'] = function () {
            return new Collection();
        };

        $this['builder'] = function () {

            $builder = new Builder();

            foreach ($this->modules->all() as $module) {
                if ($name = Arr::get($module->options, 'builder')) {

                    $options = $module->options;

                    if ($render = Arr::get($options, 'render')) {
                        if ($render instanceof \Closure) {
                            $options['render'] = $render->bindTo($module, $module);
                        }
                    }

                    $builder->add($name, $options);
                }
            }

            return $builder;
        };

        $app['builder'] = function () {
            return $this['builder'];
        };

    },

    'inject' => [

        'option' => 'app.option',
        'modules' => 'app.modules',
        'scripts' => 'app.scripts',
        'customizer' => 'theme.customizer',

    ],

    'include' => [

        '../../builder/*/index.php'

    ],

    'routes' => function ($route) {

        $route->post('/builder/library', function ($id, $element, $response) {

            $this->option->set("library.{$id}", Builder::encode($element, false));

            return $response->withJson(['message' => 'success']);
        });

        $route->delete('/builder/library', function ($id, $response) {

            $this->option->remove("library.{$id}");

            return $response->withJson(['message' => 'success']);
        });

    },

    'events' => [

        'theme.site' => function ($theme) {

            if ($this->customizer->isActive()) {

                $this->builder->addRenderer(function ($element, $type, $next) {

                    $content = $next($element, $type);

                    if ($type['config.element']) {
                        $content = preg_replace('/(^\s*<[^>]+)(>)/i', "$1 data-id=\"{$element->id}\"$2", $content, 1);
                    }

                    return $content;
                });

            }

            $this->builder->addRenderer(new ElementRenderer());
        },

        'theme.admin' => [function ($theme) {

            $this->data->set('library', new Collection($this->option->get('library')));
            $this->data->set('elements', new Collection());

            $this->app->trigger('builder.init', [$this->data->get('elements'), $this]);

            $this->scripts->add('customizer-builder', "{$this->path}/app/builder.min.js", 'customizer');

        }, -10],

        'view' => function () {
            if ($data = $this->data->all()) {
                $this->scripts->add('builder-data', sprintf('var $builder = %s;', json_encode($data)), 'customizer-builder', 'string');
            }
        }

    ],

    'config' => [

        'section' => [
            'title' => 'Builder',
            'heading' => false,
            'width' => 600,
            'priority' => 20,
        ],

        'panels' => [

            'builder-parallax' => [

                'title' => 'Parallax',
                'width' => 500,
                'fields' => [

                    'parallax_x' => [
                        'type' => 'grid',
                        'width' => '1-2',
                        'fields' => [

                            'parallax_x_start' => [
                                'label' => 'Horizontal Start',
                                'type' => 'range',
                                'attrs' => [
                                    'min' => -600,
                                    'max' => 600,
                                    'step' => 10,
                                ],
                            ],

                            'parallax_x_end' => [
                                'label' => 'Horizontal End',
                                'type' => 'range',
                                'attrs' => [
                                    'min' => -600,
                                    'max' => 600,
                                    'step' => 10,
                                ],
                            ],

                        ],
                    ],

                    'parallax_y' => [
                        'type' => 'grid',
                        'width' => '1-2',
                        'fields' => [

                            'parallax_y_start' => [
                                'label' => 'Vertical Start',
                                'type' => 'range',
                                'attrs' => [
                                    'min' => -600,
                                    'max' => 600,
                                    'step' => 10,
                                ],
                            ],

                            'parallax_y_end' => [
                                'label' => 'Vertical End',
                                'type' => 'range',
                                'attrs' => [
                                    'min' => -600,
                                    'max' => 600,
                                    'step' => 10,
                                ],
                            ],

                        ],
                    ],

                    'parallax_scale' => [
                        'type' => 'grid',
                        'width' => '1-2',
                        'fields' => [

                            'parallax_scale_start' => [
                                'label' => 'Scale Start',
                                'type' => 'range',
                                'attrs' => [
                                    'min' => 0.5,
                                    'max' => 2,
                                    'step' => 0.1,
                                ],
                            ],

                            'parallax_scale_end' => [
                                'label' => 'Scale End',
                                'type' => 'range',
                                'attrs' => [
                                    'min' => 0.5,
                                    'max' => 2,
                                    'step' => 0.1,
                                ],
                            ],

                        ],
                    ],

                    'parallax_rotate' => [
                        'type' => 'grid',
                        'width' => '1-2',
                        'fields' => [

                            'parallax_rotate_start' => [
                                'label' => 'Rotate Start',
                                'type' => 'range',
                                'attrs' => [
                                    'min' => 0,
                                    'max' => 360,
                                    'step' => 10,
                                ],
                            ],

                            'parallax_rotate_end' => [
                                'label' => 'Rotate End',
                                'type' => 'range',
                                'attrs' => [
                                    'min' => 0,
                                    'max' => 360,
                                    'step' => 10,
                                ],
                            ],

                        ],
                    ],

                    'parallax_opacity' => [
                        'type' => 'grid',
                        'width' => '1-2',
                        'fields' => [

                            'parallax_opacity_start' => [
                                'label' => 'Opacity Start',
                                'type' => 'range',
                                'attrs' => [
                                    'min' => 0,
                                    'max' => 1,
                                    'step' => 0.1,
                                ],
                            ],

                            'parallax_opacity_end' => [
                                'label' => 'Opacity End',
                                'type' => 'range',
                                'attrs' => [
                                    'min' => 0,
                                    'max' => 1,
                                    'step' => 0.1,
                                ],
                            ],

                        ],
                    ],

                    'parallax_easing' => [
                        'label' => 'Easing',
                        'description' => 'Set the animation easing. A value below 1 is faster in the beginning and slower towards the end while a value above 1 behaves inversely.',
                        'type' => 'range',
                        'attrs' => [
                            'min' => 0.1,
                            'max' => 2,
                            'step' => 0.1,
                        ],
                    ],

                    'parallax_viewport' => [
                        'label' => 'Viewport',
                        'description' => 'Set the animation end point relative to viewport height, e.g. <code>0.5</code> for 50% of the viewport',
                        'type' => 'range',
                        'attrs' => [
                            'min' => 0.1,
                            'max' => 1,
                            'step' => 0.1,
                        ],
                    ],

                    'parallax_target' => [
                        'label' => 'Target',
                        'type' => 'checkbox',
                        'text' => 'Animate the element as long as the section is visible',
                    ],

                    'parallax_zindex' => [
                        'label' => 'Z Index',
                        'type' => 'checkbox',
                        'text' => 'Set a higher stacking order.',
                    ],

                    'parallax_breakpoint' => [
                        'label' => 'Breakpoint',
                        'description' => 'Display the parallax effect only on this device width and larger.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Always' => '',
                            'Small (Phone)' => 's',
                            'Medium (Tablet)' => 'm',
                            'Large (Desktop)' => 'l',
                            'X-Large (Large Screens)' => 'xl',
                        ],
                    ],

                ],

            ],

        ],

    ],

];
