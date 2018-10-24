<?php

return [

    'name' => 'yootheme/builder-map',

    'builder' => 'map',

    'inject' => [

        'view' => 'app.view',
        'styles' => 'app.styles',
        'scripts' => 'app.scripts',

    ],

    'render' => function ($element) {

        $markers = [];
        $options = ['title', 'content', 'hide', 'show_popup'];
        $leaflet = 'https://cdn.jsdelivr.net/leaflet/1.0.2';

        foreach ($element as $marker) {

            if (!$location = $marker['location']) {
                continue;
            }

            list($lat, $lng) = explode(',', $location);

            $markers[] = $marker->pick($options)->set('lat', (float) $lat)->set('lng', (float) $lng);
        }

        if ($center = reset($markers)) {
            $element['center'] = $center->pick(['lat', 'lng']);
        } else {
            $element['center'] = ['lat' => 53.5503, 'lng' => 10.0006];
        }

        $element['markers'] = array_values(array_filter($markers, function ($marker) {
            return !$marker['hide'];
        }));

        if ($key = $this->theme->get('google_maps')) {
            $this->scripts->add('google-api', 'https://www.google.com/jsapi', [], ['defer' => true]);
            $this->scripts->add('google-maps', "var \$google_maps = '{$key}';", [], ['defer' => true, 'type' => 'string']);
        } else {
            $this->styles->add('leaflet', "{$leaflet}/leaflet.css", [], ['defer' => true]);
            $this->scripts->add('leaflet', "{$leaflet}/leaflet.js", [], ['defer' => true]);
        }

        $this->scripts->add('builder-map', '@builder/map/app/map.min.js', [], ['defer' => true]);

        return $this->view->render('@builder/map/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'show_title' => true,
            'type' => 'roadmap',
            'zoom' => 10,
            'controls' => true,
            'zooming' => false,
            'dragging' => false,

        ],

    ],

    'include' => [

        'yootheme/builder-map-marker' => [

            'builder' => 'map_marker',

        ],

    ],

];
