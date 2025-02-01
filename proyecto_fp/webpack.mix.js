
// webpack.mix.js

let mix = require('laravel-mix');

mix.js('resources/js/main.js', 'public/js')
    .postCss('resources/css/estilos.css', 'public/css');