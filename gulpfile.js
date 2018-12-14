var elixir = require('laravel-elixir');

elixir(function (mix){
        
    mix.js('resources/js/app.js', 'public/js');
    mix.sass('app.scss');
    mix.js('resources/js/highcharts','public/js');
});