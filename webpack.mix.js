const mix = require('laravel-mix');

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

mix
    /* CSS */
    .sass("resources/sass/app.scss", "public/css")
    .sass("resources/sass/custom.scss", "public/css")
    .sass(
        "resources/gull/assets/styles/sass/themes/lite-purple.scss",
        "public/assets/styles/css/themes/lite-purple.min.css"
    )
    .sass(
        "resources/gull/assets/styles/sass/themes/lite-blue.scss",
        "public/assets/styles/css/themes/lite-blue.min.css"
    )
    .sass(
        "resources/gull/assets/styles/sass/themes/lite-gray.scss",
        "public/assets/styles/css/themes/lite-gray.min.css"
    )
    .sass(
        "resources/gull/assets/styles/sass/themes/lite-slateGray.scss",
        "public/assets/styles/css/themes/lite-slateGray.min.css"
    )
    .sass(
        "resources/gull/assets/styles/sass/themes/lite-indigo.scss",
        "public/assets/styles/css/themes/lite-indigo.min.css"
    )
    .sass(
        "resources/gull/assets/styles/sass/themes/lite-pink.scss",
        "public/assets/styles/css/themes/lite-pink.min.css"
    )
    .sass(
        "resources/gull/assets/styles/sass/themes/lite-cyan.scss",
        "public/assets/styles/css/themes/lite-cyan.min.css"
    ).copyDirectory('resources/gull/assets/styles/vendor', 'public/assets/styles/vendor');

/* JS */

/* Laravel JS */

mix.combine(
    [
        "resources/gull/assets/js/vendor/jquery-3.3.1.min.js",
        "resources/gull/assets/js/vendor/bootstrap.bundle.min.js",
        "resources/gull/assets/js/vendor/perfect-scrollbar.min.js",
        './node_modules/select2/dist/js/select2.min.js',
        './node_modules/moment/min/moment-with-locales.js'
    ],
    "public/assets/js/common-bundle-script.js"
).copyDirectory('resources/gull/assets/js/vendor', 'public/assets/js/vendor')

mix.copy('resources/js/custom.js', 'public/js');

mix.js(["resources/gull/assets/js/script.js"], "public/assets/js/script.js");

mix.js( "resources/gull/assets/js/menu.sidebar-large.script.js", "public/assets/js/menu.sidebar-large.js" );
mix.js( "resources/gull/assets/js/menu.horizontal-bar.script.js", "public/assets/js/menu.horizontal-bar.js" );
