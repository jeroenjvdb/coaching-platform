var elixir = require('laravel-elixir');

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
        .scripts(['app.js', 'Stopwatch.js'], 'public/resources/js/app.js')
        .copy('resources/assets/fonts', 'public/resources/fonts');
});
