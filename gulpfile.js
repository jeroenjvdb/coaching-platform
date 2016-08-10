var elixir = require('laravel-elixir');

var paths = {
    'bootstrap': './node_modules/bootstrap-sass/assets/',
    'select2' : './node_modules/select2/dist/',
    'ckeditor': './node_modules/ckeditor/',
    'icheck': './node_modules/icheck/',
    'datetimepicker': './node_modules/datetimepicker/'
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

elixir(function (mix) {
    mix.sass('style.scss', 'public/resources/css/main.css')
        //.less('adminLTE/adminLTE.less', 'public/resources/css/adminLTE.css')
        .scripts([
            'exif.js',
            'jquery.js',
            'jquery-ui.js',
            'jquery.mobile-1.4.5.min.js',
            'touch-punch.js',
            paths.bootstrap + "javascripts/bootstrap.js",
            paths.icheck + 'icheck.min.js',
            paths.datetimepicker + 'src/DateTimePicker.js',
            'moment.min.js',
            'moment-nl.js',
            'chartjs.min.js',
            'charts.js',
            //paths.ckeditor + 'ckeditor.js',
            //paths.ckeditor + 'lang/nl.js',
            'adminLTE.js',
            'bootstrap3-wysihtml5.all.js',
            'daterangepicker.js',
            'fullcalendar.min.js',
            paths.select2 + 'js/select2.full.min.js',
            'Stopwatch.js',
            'app.js'
        ], 'public/resources/js/app.min.js')
        .copy([
            'resources/assets/fonts',
            paths.bootstrap + "fonts",
        ], 'public/resources/fonts')
        .copy(
            paths.ckeditor,
            'public/resources/js/ckeditor'
        );
});
