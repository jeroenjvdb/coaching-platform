var elixir = require('laravel-elixir');

var paths = {
    'bootstrap': './node_modules/bootstrap-sass/assets/'
};

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('style.scss', 'public/resources/css/main.css')
        .less('adminLTE/adminLTE.less', 'public/resources/css/adminLTE.css')
        .scripts([
            'jquery.js',
            'jquery-ui.js',
            'jquery.mobile-1.4.5.min.js',
            'touch-punch.js',
            paths.bootstrap + "javascripts/bootstrap.js",
            'moment.min.js',
            'adminLTE.js',
            'fullcalendar.min.js',
            'Stopwatch.js',
            'app.js'
        ], 'public/resources/js/app.js')
        .copy('resources/assets/fonts', 'public/resources/fonts');
});
