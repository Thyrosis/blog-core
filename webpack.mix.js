const fs = require('fs');
const path = require('path');
const mix = require('laravel-mix');

require('laravel-mix-tailwind');

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

mix.js('resources/js/app.js', 'public/js/core.js')
   // .sass('resources/sass/app.scss', 'public/css/core.css')
   .tailwind('./tailwind.config.js');

/**
 * Looping through the resources/sass directory, transform each found scss file
 * into the corresponding css file in public/css.
 */
const files = fs.readdirSync(path.resolve(__dirname, 'resources', 'sass'), 'utf-8')  

for (let file of files) {
   mix.sass(`resources/sass/${file}`, 'public/css');
}