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
mix.styles('resources/assets/css/scientist/login.css', 'public/build/css/scientist/login.css');
mix.styles('resources/assets/css/admin/login.css', 'public/build/css/admin/login.css');
mix.styles('resources/assets/css/roles.css', 'public/build/css/roles.css');
mix.styles('resources/assets/css/customer.css', 'public/build/css/customer.css');
mix.styles('resources/assets/css/mission-sxtns.css', 'public/build/css/mission-sxtns.css');
mix.styles('resources/assets/css/mission_science_technology/mission_science_technology.css', 'public/build/css/mission_science_technology/mission_science_technology.css');
mix.styles('resources/assets/css/timeline.css', 'public/build/css/timeline.css');
mix.styles('resources/assets/css/admin_mission_science_technology.css', 'public/build/css/admin_mission_science_technology.css');


mix.js('resources/assets/js/settings.js', 'public/build/js/settings.js');
mix.js('resources/assets/js/actions.js', 'public/build/js/actions.js');
mix.js('resources/assets/js/plugins.js', 'public/build/js/plugins.js');
mix.babel('resources/assets/js/global.js', 'public/build/js/global.js');
mix.js('resources/assets/js/roles.js', 'public/build/js/roles.js');
mix.js('resources/assets/js/permissions.js', 'public/build/js/permissions.js');
mix.js('resources/assets/js/account.js', 'public/build/js/account.js');
mix.js('resources/assets/js/account-users.js', 'public/build/js/account-users.js');
mix.js('resources/assets/js/register.js', 'public/build/js/register.js');
mix.js('resources/assets/js/mission_topic.js', 'public/build/js/mission_topic.js');
mix.js('resources/assets/js/mission_sxtns.js', 'public/build/js/mission_sxtns.js');
mix.js('resources/assets/js/mission_science_technology/mission_science_technology.js', 'public/build/js/mission_science_technology/mission_science_technology.js');
mix.js('resources/assets/js/round_collection.js', 'public/build/js/round_collection.js');
mix.js('resources/assets/js/group_council.js', 'public/build/js/group_council.js');
mix.js('resources/assets/js/council.js', 'public/build/js/council.js');
mix.js('resources/assets/js/change-avatar.js', 'public/build/js/change-avatar.js');
mix.js('resources/assets/js/admin_mission_topic.js', 'public/build/js/admin_mission_topic.js');
mix.js('resources/assets/js/admin_mission_sxtns.js', 'public/build/js/admin_mission_sxtns.js');
mix.js('resources/assets/js/admin_mission_science_technology.js', 'public/build/js/admin_mission_science_technology.js');
mix.js('resources/assets/js/missions.js', 'public/build/js/missions.js');
mix.js('resources/assets/js/login.js', 'public/build/js/login.js');
mix.js('resources/assets/js/position-councils.js', 'public/build/js/position-councils.js');







// for production
if (mix.inProduction()) {
    mix.version();
}

