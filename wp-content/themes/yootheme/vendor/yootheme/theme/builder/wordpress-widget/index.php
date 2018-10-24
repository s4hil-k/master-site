<?php

$config = [

    'name' => 'yootheme/builder-wordpress-widget',

    'builder' => 'wordpress_widget',

    'inject' => [

        'view' => 'app.view',
        'scripts' => 'app.scripts',
        'module' => 'yootheme/wordpress-widgets',

    ],

    'render' => function ($element) {

        global $wp_registered_widgets;

        if (isset($wp_registered_widgets[$element['widget']])) {

            if (!array_filter(wp_get_sidebars_widgets(), function ($position) use ($element) {
                return in_array($element['widget'], $position);
            })) {
                return '';
            }

            $instance = $wp_registered_widgets[$element['widget']];

            $defaults = [
                'name' => '',
                'id' => '',
                'description' => '',
                'class' => '',
                'before_widget' => '<content>',
                'after_widget' => '</content>',
                'before_title' => '<title>',
                'after_title' => '</title>',
                'widget_id' => $instance['id'],
                'widget_name' => $instance['name'],
                'yoo_element' => $element
            ];

            if (isset($instance['callback']) && is_callable($instance['callback'])) {

                call_user_func($instance['callback'], wp_parse_args($instance, $defaults), $instance['params'][0]);

                if ($widget = array_pop($this->module->widgets[$this->module->sidebar])) {
                    $element->title = $widget->title;
                    $element->content = $widget->content;
                    $element->widget = $widget;
                    $element->props = $widget->config->merge($element->props, true);
                }
            }
        }

        return $element->content ? $this->view->render('@builder/wordpress-widget/template', compact('element')) : '';
    },

    'events' => [

        'builder.init' => function ($elements, $builder) {
            $elements->set('wordpress_widget', json_decode(file_get_contents("{$this->path}/wordpress-widget.json"), true));
        }

    ],

    'config' => [

        'element' => true,

    ],

];

return defined('WPINC') ? $config : false;
