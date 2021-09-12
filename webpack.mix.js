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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/index.js', 'public/js')
    .js('resources/js/view.js', 'public/js')
    .js('resources/js/viewbasket.js', 'public/js')
    .js('resources/js/checkout.js', 'public/js')
    .js('resources/js/presubmit.js', 'public/js')
    .js('resources/js/makepayment.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .postCss('resources/css/vendor.css', 'public/css')
    .postCss('resources/css/styles.css', 'public/css')




// mix.js('resources/js/app.js', 'public/js').postCss('resources/css/*.css', 'public/css', [
//     require('postcss-import'),
//     require('tailwindcss'),
//     require('autoprefixer'),
// ]);
