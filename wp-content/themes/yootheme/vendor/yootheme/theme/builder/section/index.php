<?php

return [

    'name' => 'yootheme/builder-section',

    'builder' => 'section',

    'inject' => [

        'view' => 'app.view',
        'scripts' => 'app.scripts',

    ],

    'render' => function ($element) {

        // Deprecated
        if ($element['image_effect'] === null) {
            $element['image_effect'] = $element['image_fixed'] ? 'fixed' : '';
        }
        if ($element['vertical_align'] === null && in_array($element['height'], ['full', 'percent', 'section'])) {
            $element['vertical_align'] = 'middle';
        }
        if ($element['style'] == 'video') {
            $element['style'] = 'default';
        }

        return $this->view->render('@builder/section/template', compact('element'));
    },

    'config' => [

        'defaults' => [

            'style' => 'default',
            'width' => 'default',
            'vertical_align' => 'middle',
            'title_position' => 'top-left',
            'title_rotation' => 'left',
            'title_breakpoint' => 'l',
            'image_position' => 'center-center',

        ],

    ],

];
