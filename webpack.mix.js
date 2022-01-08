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

mix.js('resources/js/app.js', 'public/js/vue.js')
    .vue();

mix.copyDirectory('resources/lte', 'public/lte' );
mix.copyDirectory('resources/img', 'public/img' );
mix.copyDirectory('resources/js.lib', 'public/js.lib' );

// mix.sass('resources/sass/app.scss', 'public/css')    ;
// .sourceMaps()
