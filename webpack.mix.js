const mix = require('laravel-mix');

mix
  .setPublicPath('./assets')

mix
  .sass('resources/styles/style.scss', 'css');

mix
  .js('resources/scripts/script.js', 'js')
