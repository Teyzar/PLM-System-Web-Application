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

mix.js('resources/js/app.js', 'public/js')
    .copy('resources/js/pages/', 'public/js/pages')
    .copy('resources/js/button-theme-settings.js', 'public/js')
    .copy('resources/js/*.min.js', 'public/js')
    .copy('resources/js/*.min.js.map', 'public/js')
    .copy('resources/js/*.min-min.js', 'public/js')
    .copy('resources/js/*.min-min.js.map', 'public/js')
    .copy('resources/js/vendor.js', 'public/js')
    .sass("resources/sass/bootstrap.scss", "public/css")
    .copy('resources/css/', 'public/css')
    .copy('resources/css/config/', 'public/css/config')
    .copy('resources/libs/moment/min/moment.min.js', 'public/libs/moment/min')
    .copy('resources/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'public/libs/datatables.net-bs5/css')
    .copy('resources/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'public/libs/datatables.net-responsive-bs5/css')
    .copy('resources/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css', 'public/libs/datatables.net-buttons-bs5/css')
    .copy('resources/libs/datatables.net/js/jquery.dataTables.min.js', 'public/libs/datatables.net/js')
    .copy('resources/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js', 'public/libs/datatables.net-bs5/js')
    .copy('resources/libs/datatables.net-responsive/js/dataTables.responsive.min.js', 'public/libs/datatables.net-responsive/js')
    .copy('resources/libs/datatables.net-buttons/js/dataTables.buttons.min.js', 'public/libs/datatables.net-buttons/js')
    .copy('resources/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js', 'public/libs/datatables.net-buttons-bs5/js')
    .copy('resources/libs/datatables.net-buttons/js/buttons.html5.min.js', 'public/libs/datatables.net-buttons/js')
    .copy('resources/libs/datatables.net-buttons/js/buttons.flash.min.js', 'public/libs/datatables.net-buttons/js')
    .copy('resources/libs/datatables.net-buttons/js/buttons.print.min.js', 'public/libs/datatables.net-buttons/js')
    .copy('resources/libs/pdfmake/build/pdfmake.min.js', 'public/libs/pdfmake/build')
    .copy('resources/libs/pdfmake/build/vfs_fonts.js', 'public/libs/pdfmake/build')
    .copy('resources/libs/feather-icons/icons/', 'public/libs/feather-icons/icons')
    .copy('resources/libs/feather-icons/icons/', 'public/libs/feather-icons/icons')
    .copy('resources/images/', 'public/images')
    .copy('resources/fonts/', 'public/fonts')
    .version()
    .sourceMaps();








