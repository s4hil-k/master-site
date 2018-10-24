<?php

return [

    'name' => 'yootheme/builder-overlay',

    'builder' => 'overlay',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {

        // Deprecated
        if ($element['overlay_image'] === null) {
            $element['overlay_image'] = $element['image2'];
        }

        if (empty($element['image']) && empty($element['hover_image'])) {
            $element['image'] = $this->app->url('@assets/images/element-image-placeholder.png');
        }

        return $this->view->render('@builder/overlay/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'overlay_mode' => 'cover',
            'overlay_hover' => true,
            'overlay_style' => 'overlay-primary',
            'text_color' => 'light',
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

        'props' => [
            'title' => 'Overlay',
        ],

    ],

];
