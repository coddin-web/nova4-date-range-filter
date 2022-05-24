let mix = require('laravel-mix')

require('./nova.mix')

mix.setPublicPath('dist')
    .js('resources/js/index.js', 'js/date-range-filter.js')
    .vue({ version: 3 })
    .css('resources/airbnb-modified.css', 'css/date-range-filter.css')
    .nova('ampeco/nova-date-range-filter')
