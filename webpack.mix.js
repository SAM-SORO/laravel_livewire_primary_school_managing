const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       require('tailwindcss'),
   ])
   // Copier les fichiers de SweetAlert2 dans le répertoire public
   .copy('node_modules/sweetalert2/dist/sweetalert2.all.min.js', 'public/js/sweetalert2.all.min.js')
   .copy('node_modules/sweetalert2/dist/sweetalert2.min.css', 'public/css/sweetalert2.min.css')
   // Versionner les fichiers compilés
   .version();
