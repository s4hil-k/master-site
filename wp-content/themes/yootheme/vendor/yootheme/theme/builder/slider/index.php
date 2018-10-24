<?php

return [

    'name' => 'yootheme/builder-slider',

    'builder' => 'slider',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {

        foreach ($element as $child) {
            if (empty($child['image']) && empty($child['video'])) {
                $child['image'] = $this->app->url('@assets/images/element-image-placeholder.png');
            }
        }

        return $this->view->render('@builder/slider/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'show_title' => true,
            'show_meta' => true,
            'show_content' => true,
            'show_link' => true,

            'slider_width' => 'fixed',
            'slider_width_default' => '1-1',
            'slider_width_medium' => '1-3',
            'slider_min_height' => 300,
            'slider_gutter' => 'default',

            'slider_autoplay_pause' => true,

            'nav' => 'dotnav',
            'nav_align' => 'center',
            'nav_breakpoint' => 's',

            'slidenav' => 'default',
            'slidenav_margin' => 'medium',
            'slidenav_breakpoint' => 's',
            'slidenav_outside_breakpoint' => 'xl',

            'overlay_mode' => 'cover',
            'overlay_position' => 'center',
            'overlay_transition' => 'fade',

            'title_element' => 'h3',
            'meta_style' => 'meta',
            'meta_align' => 'bottom',

            'text_align' => 'center',
            'margin' => 'default',

        ],

    ],

    'default' => [

        'children' => array_fill(0, 5, [
            'type' => 'slider_item',
        ])

    ],

    'include' => [

        'yootheme/builder-slider-item' => [

            'builder' => 'slider_item',

        ],

    ],

];
