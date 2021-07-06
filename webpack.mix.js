const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .js('resources/js/app.js', 'public/js')
  .postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
  ])
  .postCss('resources/css/front.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
  ])
  .js('resources/js/sortable.js', 'js')
  .js('resources/js/ckeditor.js', 'js')
  .js('resources/js/flatpickr.js', 'js') 
  .js('resources/js/swiper.js', 'js') 
   
  .js('resources/js/home.js', 'js')
  .js('resources/js/about-us.js', 'js')
  .js('resources/js/gallery.js', 'js')

  .options({
    processCssUrls: false
  })
  .webpackConfig(require('./webpack.config'));
  
