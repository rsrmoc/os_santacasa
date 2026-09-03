const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');


mix.js('resources/js/acma/home.js', 'public/js/acma');
mix.js('resources/js/acma/usuarios.js', 'public/js/acma');
mix.js('resources/js/acma/chamados.js', 'public/js/acma');

mix.js('resources/js/paginas/cadastro.js', 'public/js/paginas');
mix.js('resources/js/paginas/controle.js', 'public/js/paginas');
mix.js('resources/js/paginas/clientes.js', 'public/js/paginas');
mix.js('resources/js/paginas/negociacoes.js', 'public/js/paginas');
mix.js('resources/js/paginas/contas/pagar.js', 'public/js/paginas/contas');
mix.js('resources/js/paginas/contas/receber.js', 'public/js/paginas/contas');


