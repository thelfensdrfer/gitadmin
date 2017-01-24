const elixir = require('laravel-elixir');

var elixirTypscript = require('elixir-typescript');

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
        '../../../node_modules/semantic-ui/dist/semantic.min.css',
        '../../../node_modules/font-awesome/css/font-awesome.min.css',
        '../../../node_modules/alertify.js/dist/css/alertify.css',
        '../../../node_modules/semantic-ui-calendar/dist/calendar.min.css',
        'app.css'
    ]);

    mix.typescript('app.ts', 'resources/assets/js/app.js');

    mix.scripts([
    	'../../../node_modules/jquery/dist/jquery.min.js',
        '../../../node_modules/semantic-ui/dist/semantic.min.js',
        '../../../node_modules/alertify.js/dist/js/alertify.js',
        '../../../node_modules/semantic-ui-calendar/dist/calendar.min.js',
        'app.js'
    ]);

    mix.copy('node_modules/font-awesome/fonts', 'public/fonts');
});
