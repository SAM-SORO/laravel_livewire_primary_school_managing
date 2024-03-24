const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       require('tailwindcss'),
]).version();

// En résumé, ce code indique à Laravel Mix de prendre le fichier resources/css/app.css, d'appliquer les transformations de Tailwind CSS et de compiler le résultat dans le fichier public/css/app.css.

