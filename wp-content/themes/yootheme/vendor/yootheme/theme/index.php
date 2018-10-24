<?php

const REGEX_IMAGE = '#\.(gif|png|jpe?g|svg)$#';
const REGEX_VIDEO = '#\.(mp4|m4v|ogv|webm)$#';
const REGEX_VIMEO = '#(?:player\.)?vimeo\.com(?:/video)?/(\d+)#i';
const REGEX_YOUTUBE = '#(?:youtube(-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})#i';
const REGEX_UNSPLASH = '#images\.unsplash\.com/(?<id>[\w-]+)#i';

// demo images

return [

    'name' => 'yootheme/theme',

    'main' => function ($app) {

        $app['locator']
            ->addPath("{$this->path}/builder", 'builder')
            ->addPath("{$this->path}/assets", 'assets')
            ->addPath("{$this->path}/platforms", 'assets/platforms');

        $app->extend('image', function ($image) use ($app) {

            $convert = $this->theme->get('webp') && is_callable('imagewebp') && strpos($app['request']->getHeaderLine('Accept'), 'image/webp') !== false
                ? ['png' => 'webp,100', 'jpeg' => 'webp,85']
                : false;

            $image->addLoader(function ($image) use ($convert) {

                $params = $image->getAttribute('params', []);

                // convert image type?
                if ($convert && !isset($params['type'])) {

                    $type = $image->getType();

                    if (isset($convert[$type])) {
                        $params['type'] = $convert[$type];
                    }

                }

                // image covers
                if (isset($params['covers']) && $params['covers'] && !isset($params['sizes'])) {
                    $ratio = round($image->width / $image->height * 100);
                    $params['sizes'] = "(max-aspect-ratio: {$image->width}/{$image->height}) {$ratio}vh";
                }

                // set default srcset
                if (isset($params['srcset']) && $params['srcset'] === '1') {
                    $params['srcset'] = '768,1024,1366,1600,1920,200%';
                }

                $image->setAttribute('params', $params);

            });

        });

        $app->extend('view', function ($view) use ($app) {

            $view->addFunction('social', function ($link) {

                static $icons;

                if (is_null($icons)) {
                    $icons = json_decode(file_get_contents("{$this->path}/app/data/icons.json"), true);
                    $icons = $icons['Brand Icons'];
                }

                if (strpos($link, 'mailto:') === 0) {
                    return 'mail';
                }

                if (strpos($link, 'tel:') === 0) {
                    return 'receiver';
                }

                if (preg_match('#google\.(.+?)/maps/(.+)#i', $link)) {
                    return 'location';
                }

                $icon = parse_url($link, PHP_URL_HOST);
                $icon = preg_replace('/.*?(plus\.google|\w{3,}[^.]).*/i', '$1', $icon);
                $icon = str_replace('plus.google', 'google-plus', $icon);

                if (!in_array($icon, $icons)) {
                    $icon = 'social';
                }

                return $icon;
            });

            $view->addFunction('iframeVideo', function ($link, $params = [], $defaults = true) {

                $query = parse_url($link, PHP_URL_QUERY);

                if ($query) {
                    parse_str($query, $_params);
                    $params = array_merge($_params, $params);
                }

                if (preg_match(REGEX_VIMEO, $link, $matches)) {
                    return $this->app->url("https://player.vimeo.com/video/{$matches[1]}", $defaults ? array_merge([
                        'loop' => 1,
                        'autoplay' => 1,
                        'title' => 0,
                        'byline' => 0,
                        'setVolume' => 0
                    ], $params) : $params);
                }

                if (preg_match(REGEX_YOUTUBE, $link, $matches)) {

                    if (!empty($params['loop'])) {
                        $params['playlist'] = $matches[2];
                    }

                    if (empty($params['controls'])) {
                        $params['disablekb'] = 1;
                    }

                    return $this->app->url("https://www.youtube{$matches[1]}.com/embed/{$matches[2]}", $defaults ? array_merge([
                        'rel' => 0,
                        'loop' => 1,
                        'playlist' => $matches[2],
                        'autoplay' => 1,
                        'controls' => 0,
                        'showinfo' => 0,
                        'iv_load_policy' => 3,
                        'modestbranding' => 1,
                        'wmode' => 'transparent',
                        'playsinline' => 1
                    ], $params) : $params);
                }

            });

            $view->addFunction('isImage', function ($link) {

                return $link && preg_match(REGEX_IMAGE, $link, $matches) ? $matches[1] : false;

            });

            $view->addFunction('isVideo', function ($link) {

                return $link && preg_match(REGEX_VIDEO, $link, $matches) ? $matches[1] : false;

            });

            $view->addFunction('image', function ($url, array $attrs = []) use ($view) {

                $url = (array) $url;
                $path = array_shift($url);
                $isAbsolute = !$this->customizer->isActive() && preg_match('/^\/|#|[a-z0-9-.]+:/', $path);

                if (isset($url['thumbnail']) && count($url['thumbnail']) > 1 && preg_match(REGEX_UNSPLASH, $path, $matches)) {
                    $path = "https://images.unsplash.com/{$matches['id']}?fit=crop&w={$url['thumbnail'][0]}&h={$url['thumbnail'][1]}";
                }

                // demo images image

                $params = $url && !$isAbsolute && $view->isImage($path) != 'gif' ? '#' . http_build_query(array_map(function ($value) {
                        return is_array($value) ? implode(',', $value) : $value;
                    }, $url), '', '&') : '';

                if (empty($attrs['alt'])) {
                    $attrs['alt'] = true;
                }

                $src = 'src';
                if (!empty($attrs['uk-img'])) {

                    if (!$this->theme->get('lazyload')) {
                        unset($attrs['uk-img']);
                    } else {
                        $src = 'data-src';
                    }

                }

                return "<img{$view->attrs([$src => $path.$params], $attrs)}>";

            });

            $view->addFunction('bgImage', function ($url, array $params = []) use ($app, $view) {

                // demo images bgImage

                $attrs = [];
                $lazyload = $this->theme->get('lazyload');
                $isResized = $params['width'] || $params['height'];
                $type = $view->isImage($url);
                $isAbsolute = preg_match('/^\/|#|[a-z0-9-.]+:/', $url);

                if ($type == 'svg') {
                    if ($isResized && !$params['size']) {
                        $width = $params['width'] ? "{$params['width']}px" : 'auto';
                        $height = $params['height'] ? "{$params['height']}px" : 'auto';
                        $attrs['style'][] = "background-size: {$width} {$height};";
                    }
                } else if (!$isAbsolute && $type != 'gif') {
                    $url .= '#srcset=1';
                    $url .= '&covers='.((int) $params['size'] === 'covers');
                    $url .= '&thumbnail'.($isResized ? "={$params['width']},{$params['height']}" : '');
                } else if (preg_match(REGEX_UNSPLASH, $url, $matches)) {
                    $url = "https://images.unsplash.com/{$matches['id']}?fit=crop&w={$params['width']}&h={$params['height']}";
                }

                if ($lazyload) {

                    if ($image = $app['image']->create($url, false)) {
                        $attrs = array_merge($attrs, $app['image']->getSrcsetAttrs($image, 'data-'));
                    } else {
                        $attrs['data-src'][] = $app['image']->getUrl($url);
                    }

                    $attrs['uk-img'] = true;

                } else {
                    $attrs['style'][] = "background-image: url('{$app['image']->getUrl($url)}');";
                }

                $attrs['class'][] = 'uk-background-norepeat';
                $attrs['class'][] = $params['size'] ? "uk-background-{$params['size']}" : '';
                $attrs['class'][] = $params['position'] ? "uk-background-{$params['position']}" : '';
                $attrs['class'][] = $params['visibility'] ? "uk-background-image@{$params['visibility']}" : '';
                $attrs['class'][] = $params['blend_mode'] ? "uk-background-blend-{$params['blend_mode']}" : '';
                $attrs['style'][] = $params['background'] ? "background-color: {$params['background']};" : '';

                switch ($params['effect']) {
                    case '':
                        break;
                    case 'fixed':
                        $attrs['class'][] = 'uk-background-fixed';
                        break;
                    case 'parallax':

                        $options = [];

                        foreach(['bgx', 'bgy'] as $prop) {
                            $start = $params["parallax_{$prop}_start"];
                            $end = $params["parallax_{$prop}_end"];

                            if (strlen($start) || strlen($end)) {
                                $options[] = "{$prop}: " . (strlen($start) ? $start : 0) . "," . (strlen($end) ? $end : 0);
                            }
                        }

                        $options[] = $params['parallax_breakpoint'] ? "media: @{$params['parallax_breakpoint']}" : '';
                        $attrs['uk-parallax'] = implode(';', array_filter($options));

                        break;
                }

                return $attrs;

            });

        });

        $app->extend('routes', function ($routes) use ($app) {
            $routes->getRoute('@image')->setAttribute('save', !$this->customizer->isActive());
        });

    },

    'require' => 'yootheme/framework',

    'include' => [

        'modules/*/index.php',
        'platforms/*/index.php',

    ],

    'inject' => [

        'view' => 'app.view',
        'assets' => 'app.assets',
        'scripts' => 'app.scripts',
        'modules' => 'app.modules',
        'translator' => 'app.translator',
        'customizer' => 'theme.customizer',

    ],

    'events' => [

        'theme.init' => function () {

            $this->assets->setVersion($this->theme->options['version']);
            $this->scripts->register('runtime', "{$this->path}/app/runtime.min.js", 'config');
            $this->scripts->register('commons', "{$this->path}/app/commons.min.js", 'runtime');
            $this->scripts->register('app-config', "{$this->path}/app/config.min.js", 'runtime');
            $this->scripts->register('uikit', 'vendor/assets/uikit/dist/js/uikit.min.js');
            $this->scripts->register('uikit-icons', 'vendor/assets/uikit/dist/js/uikit-icons.min.js', '~uikit');

        },

        'theme.site' => function () {
            if ($this->customizer->isActive()) {
                $this->scripts->add('preventAutofocus', "{$this->path}/assets/js/preventAutofocus.js");
            }
        },

        'theme.admin' => [function () {

            $this->customizer->mergeData([
                'name' => $this->theme->name,
                'base' => $this->app->url($this->theme->path),
                'api' => 'https://yootheme.com/api',
            ]);

            foreach ($this->modules->all() as $module) {

                if ($section = $module->config->get('section')) {

                    if ($fields = $module->config->get('fields')) {
                        $section['fields'] = $fields;
                    }

                    $this->customizer->addSection(basename($module->name), $section);
                }

                if ($panels = $module->config->get('panels')) {
                    $this->customizer->addData('panels', $panels);
                }
            }

            $this->translator->addResource("{$this->path}/languages/{locale}.json");

        }, -10]

    ],

];
