<?php

return [

    'name' => 'yootheme/builder-description-list',

    'builder' => 'description_list',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {

        // Deprecated
        if ($element['title_style'] == 'muted') {
            $element['title_style'] = '';
            $element['title_color'] = 'muted';
        }

        // Deprecated
        switch ($element['layout']) {
            case '':
                $element['width'] = 'auto';
                $element['layout'] = 'grid-2';
                break;
            case 'width-small':
                $element['width'] = 'small';
                $element['layout'] = 'grid-2';
                break;
            case 'width-medium':
                $element['width'] = 'medium';
                $element['layout'] = 'grid-2';
                break;
            case 'space-between':
                $element['width'] = 'expand';
                $element['layout'] = 'grid-2';
                break;

        }

        return $this->view->render('@builder/description-list/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'show_title' => true,
            'show_meta' => true,
            'show_content' => true,
            'show_link' => true,

            'layout' => 'grid-2',
            'width' => 'auto',
            'gutter' => 'small',

            'meta_style' => 'meta',
            'meta_align' => 'bottom-content',

        ],

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'description_list_item',
        ]),

    ],

    'include' => [

        'yootheme/builder-description-list-item' => [

            'builder' => 'description_list_item',

            'default' => [

                'props' => [
                    'content' => 'Lorem ipsum dolor sit amet.',
                    'title' => 'Item',
                ],

            ],

        ],

    ],

];
