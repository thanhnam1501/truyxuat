let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles('resources/assets/css/theme-default.css', 'public/build/css/theme-default.css');
mix.styles('resources/assets/css/theme-black.css', 'public/build/css/theme-black.css');
mix.styles('resources/assets/css/theme-blue.css', 'public/build/css/theme-blue.css');
mix.styles('resources/assets/css/theme-brown.css', 'public/build/css/theme-brown.css');
mix.styles('resources/assets/css/theme-white.css', 'public/build/css/theme-white.css');


mix.js('resources/assets/js/settings.js', 'public/build/js/settings.js');
mix.js('resources/assets/js/actions.js', 'public/build/js/actions.js');
mix.js('resources/assets/js/plugins.js', 'public/build/js/plugins.js');
mix.js('resources/assets/js/global.js', 'public/build/js/global.js');