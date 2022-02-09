const mix = require("laravel-mix");

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

mix.sass("resources/sass/bootstrap.scss", "public/css")
    .js("resources/js/app.js", "public/js")
    .ts("resources/js/home.ts", "public/js")
    .copy("resources/css/", "public/css")
    .copy("resources/img/", "public/img")
    .sourceMaps();
