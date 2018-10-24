<?php

return [

    'name' => 'yootheme/builder-panel',

    'builder' => 'panel',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {
        return $this->view->render('@builder/panel/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'link_text' => 'Read more',

            'title_element' => 'h3',
            'meta_style' => 'meta',
            'meta_align' => 'bottom',
            'icon_ratio' => 4,
            'image_align' => 'top',
            'image_grid_width' => '1-2',
            'image_breakpoint' => 'm',
            'link_style' => 'default',

            'margin' => 'default',

        ],

    ],

    'default' => [

        'props' => [
            'title' => 'Panel',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
        ],

    ],

];
