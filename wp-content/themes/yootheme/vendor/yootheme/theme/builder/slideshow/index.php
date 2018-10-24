<?php

return [

    'name' => 'yootheme/builder-slideshow',

    'builder' => 'slideshow',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {

        foreach ($element as $child) {
            if (empty($child['image']) && empty($child['video'])) {
                $child['image'] = $this->app->url('@assets/images/element-image-placeholder.png');
            }
        }

        return $this->view->render('@builder/slideshow/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'show_title' => true,
            'show_meta' => true,
            'show_content' => true,
            'show_link' => true,
            'show_thumbnail' => true,

            'slideshow_min_height' => 300,

            'slideshow_autoplay_pause' => true,

            'nav' => 'dotnav',
            'nav_position' => 'bottom-center',
            'nav_position_margin' => 'medium',
            'nav_align' => 'center',
            'nav_breakpoint' => 's',
            'thumbnav_width' => '100',
            'thumbnav_height' => '75',

            'slidenav' => 'default',
            'slidenav_margin' => 'medium',
            'slidenav_breakpoint' => 's',
            'slidenav_outside_breakpoint' => 'xl',

            'overlay_position' => 'center-left',
            'overlay_animation' => 'parallax',

            'title_element' => 'h3',

            'meta_style' => 'meta',
            'meta_align' => 'bottom',

            'link_text' => 'Read more',
            'link_style' => 'default',

            'margin' => 'default',

        ],

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'slideshow_item',
        ])

    ],

    'include' => [

        'yootheme/builder-slideshow-item' => [

            'builder' => 'slideshow_item',

        ],

    ],

];
