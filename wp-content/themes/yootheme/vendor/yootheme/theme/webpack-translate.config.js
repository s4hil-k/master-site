/* eslint-env node */
const fs = require('fs');
const symlinkDir = require('symlink-dir');
const {dirname, isAbsolute, resolve} = require('path');
const {merge, forOwn, isObject} = require('lodash');
const spawnSync = require('child_process').spawnSync;
const path = require('path');
const {VueLoaderPlugin} = require('vue-loader');
const GettextPlugin = require('@yootheme/scripts/extractor');

// symlink uikit
const uikitPath = resolve(__dirname, '../../assets/uikit');
if (!fs.existsSync(resolve(uikitPath, '.git'))) {
    symlink(resolve(require.resolve('uikit'), '../../../'), uikitPath);
}

// symlink styler tests
symlink('packages/data', 'app/data');
symlink('assets/images', 'assets/images');
symlink('assets/less', 'assets/less');
symlink('packages/styler/tests', 'modules/styler/tests');

const config = {

    mode: 'development',

    devtool: false,

    context: __dirname,

    output: {
        path: __dirname
    },

    resolve: {
        alias: {
            lodash: 'lodash-es',
            Components: resolve(__dirname, 'app/components'),
        }
    },

    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules(?!\/@yootheme|\/vue-color)/,
                use: 'babel-loader'
            },
            {
                test: /\.vue$/,
                use: 'vue-loader'
            },
            {
                test: /\.html$/,
                use: 'vue-html-loader'
            },
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader']
            },
            {
                test: /\.svg$/,
                use: {
                    loader: 'html-loader',
                    options: {
                        removeAttributeQuotes: false
                    }
                }
            }
        ]
    },

    plugins: [
        new VueLoaderPlugin(),
        new GettextPlugin({
            // Path to workdir
            pathToDir: __dirname,
            saveFilePath: '/languages/en_GB.json',
            parseJson(obj) {
                const result = [];
                function iterate(obj, stack) {

                    forOwn(obj, (value, key) => {

                        if (isObject(obj[key])) {
                            iterate(obj[key], stack + '.' + key);
                        } else if (key === 'title' || key === 'description' || key === 'text' || key === 'label') {
                            value = value.replace(/"/g, '\\"');
                            result.push({
                                key: `$t("${value}")`
                            });
                        }

                    });
                }
                iterate(obj, '');

                return result;
            },
            beforeSortKeys() {
                // beforeSortKeys function merged returning object, fired before file creating and keys sorting
                const result = {};

                // extract strings from .php files
                const script = path.resolve(`${__dirname}/_build/gulp/theme/scripts/translate.php`);
                const res = spawnSync('php', [script], {encoding: 'utf8'});

                let values = res.stdout.toString();

                // additional .json files (not included in webpack)
                const jsonFiles = [
                    path.resolve(`${__dirname}/builder/joomla-module/joomla-module.json`),
                    path.resolve(`${__dirname}/builder/wordpress-area/wordpress-area.json`),
                    path.resolve(`${__dirname}/builder/wordpress-widget/wordpress-widget.json`)
                ];

                jsonFiles.forEach(file => {
                    let obj = fs.readFileSync(file, {encoding: 'utf8'});

                    obj = JSON.parse(obj);
                    function iterate(obj, stack) {
                        forOwn(obj, (value, key) => {

                            if (isObject(obj[key])) {
                                iterate(obj[key], stack + '.' + key);
                            } else if (key === 'title' || key === 'description' || key === 'text' || key === 'label') {
                                values += value + '\n';
                            }

                        });
                    }

                    iterate(obj, '');
                });

                values.split('\n').forEach(value => {
                    if (value !== '') {
                        result[value] = value;
                    }
                });

                return result;
            },
            afterCreateFile() {
                // // afterCreateFile function, only fire if file created without errors
                // console.log('File created');
            }
        })
    ]

};

module.exports = [

    merge({

        entry: {

            // config
            'app/config': './app/config',

            // modules
            'modules/styler/app/styler': './modules/styler/app/styler',
            'modules/builder/app/builder': './modules/builder/app/builder',
            'modules/settings/app/about': './modules/settings/app/about.vue',

            // joomla
            'platforms/joomla/app/customizer': './platforms/joomla/app',
            'platforms/joomla-menus/app/menus': './platforms/joomla-menus/app/menus',
            'platforms/joomla-modules/app/modules': './platforms/joomla-modules/app/modules',

            // wordpress
            'platforms/wordpress/app/customizer': './platforms/wordpress/app',
            'platforms/wordpress-widgets/app/widgets': './platforms/wordpress-widgets/app/widgets',
            'platforms/wordpress-widgets/app/widget-builder': './platforms/wordpress-widgets/app/widget-builder',

        },

        output: {
            filename: './[name].min.js'
        },

        externals: {
            'jquery': 'jQuery',
            'uikit': 'UIkit',
            'uikit-util': 'UIkit.util',
        },

        optimization: {

            runtimeChunk: {
                name: 'app/runtime'
            },

            // https://gist.github.com/sokra/1522d586b8e5c0f5072d7565c2bee693
            splitChunks: {
                cacheGroups: {
                    commons: {
                        name: 'app/commons',
                        chunks: 'initial',
                        minChunks: 2
                    }
                }
            },

        }

    }, config),

    merge({

        entry: {
            'platforms/joomla-modules/app/module-edit': './platforms/joomla-modules/app/module-edit'
        },

        output: {
            filename: './[name].min.js'
        },

        externals: {
            'jquery': 'jQuery'
        },

        performance: {
            hints: false
        }

    }, config),

    merge({

        target: 'webworker',

        entry: {
            'modules/styler/app/worker': '@yootheme/packages/styler/src/lib/worker'
        },

        output: {
            filename: './[name].min.js'
        },

        performance: {
            hints: false
        },

        node: {
            fs: 'empty'
        }

    }, config),

    merge({

        entry: {
            // builder
            'builder/map/app/map': './builder/map/app/map.js',
            'builder/newsletter/app/newsletter': './builder/newsletter/app/newsletter.js',
        },

        output: {
            filename: './[name].min.js'
        },

        externals: {
            'uikit-util': 'UIkit.util',
        },

        performance: {
            hints: false
        }

    }, config),

];

function symlink(src, dest, basePath = dirname(require.resolve('@yootheme/webpack.config.js'))) {
    symlinkDir(
        isAbsolute(src) ? src : resolve(basePath, src),
        isAbsolute(dest) ? dest : resolve(__dirname, dest),
    ).catch(() => {});
}
