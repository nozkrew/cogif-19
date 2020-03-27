const $ = require('jquery');
global.$ = global.jQuery = $;

require('bootstrap');
require('bootstrap/dist/css/bootstrap.min.css');
require('bootstrap/dist/js/bootstrap.bundle.js');

//FontAwesome
require('@fortawesome/fontawesome-free/css/all.css');
require('@fortawesome/fontawesome-free/js/all.js');

require('../css/app.css');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});