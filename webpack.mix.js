/* jshint asi: true, esversion: 6 */


const { mix } = require('laravel-mix');
const path = require('path');

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

//mix.js('resources/assets/js/app.js', 'public/js')
   //.sass('resources/assets/sass/app.scss', 'public/css');

var paths = {
'bootstrap': './node_modules/bootstrap-sass/assets/'
, 'fontawesome': './node_modules/font-awesome/'
, 'datatables': './node_modules/datatables.net-bs/'
, 'adminlte': './node_modules/admin-lte/dist/'
, 'bower_components': './vendor/bower_components/'
, 'node_modules': './node_modules/'
, 'starterkit': './resources/assets/sass/starterkit/'
};

mix.webpackConfig({
    resolve: {
        modules: [
			"node_modules/",
            path.resolve(__dirname, 'vendor/bower_components/')
        ]
    }
});
mix.sass('resources/assets/sass/app.scss', 'public/css/'
		, {includePaths: [
			paths.bootstrap + 'stylesheets'
				, paths.fontawesome + 'scss'
				, paths.datatables + 'css'
				, paths.node_modules + 'eonasdan-bootstrap-datetimepicker/src/sass'
				, paths.adminlte + 'css'
				, paths.adminlte + 'css/skins'
				, paths.starterkit
		] })
	.copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts/bootstrap')
	.copy(paths.fontawesome + 'fonts/**', 'public/fonts/fontawesome')
	.js('./resources/javascripts/app.js', 'public/js/')

if (mix.config.inProduction) {
	mix.version()
} else {
	mix.sourceMaps()
}


