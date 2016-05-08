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

/*
elixir(function(mix) {
    mix.sass('app.scss');
});
*/

var paths = {
'jquery': './vendor/bower_components/jquery/'
, 'bootstrap': './vendor/bower_components/bootstrap-sass/assets/'
, 'fontawesome': './vendor/bower_components/font-awesome/'
, 'datatables': './vendor/bower_components/datatables/media/'
, 'adminlte': './vendor/bower_components/AdminLTE/dist/'
, 'bootstrap_notify': './vendor/bower_components/remarkable-bootstrap-notify/dist/'
, 'starterkit': './resources/assets/sass/starterkit/'
}

elixir(function(mix) {
    mix.sass('app.scss', 'public/css/'
			, {includePaths: [
				paths.bootstrap + 'stylesheets'
					, paths.fontawesome + 'scss'
					, paths.datatables + 'css'
					, paths.adminlte + 'css'
					, paths.adminlte + 'css/skins'
					, paths.starterkit
			] })
        .copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts/bootstrap')
        .copy(paths.fontawesome + 'fonts/**', 'public/fonts/fontawesome')
        .scripts([
			'./resources/javascripts/error/_error_handler.js',
            paths.jquery + "dist/jquery.js",
			'./resources/javascripts/error/jquery_error_handler.js',
            paths.datatables + "js/jquery.dataTables.js",
            paths.bootstrap + "javascripts/bootstrap.js",
            paths.datatables + "js/dataTables.bootstrap.js",
            paths.adminlte + "js/app.js",
            paths.bootstrap_notify + "bootstrap-notify.js",
            './resources/javascripts/common/**/*.js',
            './resources/javascripts/anon/**/*.js',
            './resources/javascripts/logged/**/*.js',
        ], 'public/js/app.js', './')
        .version([
            'css/app.css',
            'js/app.js'
        ])
});
