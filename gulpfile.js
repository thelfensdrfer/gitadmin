const elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.styles([
        '../components/semantic/dist/semantic.min.css',
        'app.css'
    ]);

    mix.scripts([
    	'../components/jquery/dist/jquery.slim.min.js',
        '../components/semantic/dist/semantic.min.js',
        'app.js'
    ]);
});