define([
    'jquery'
], function ($) {
    'use strict';

    return function (config, element) {

        $('#btn_click_3').click(function () {
            console.log(config);
            console.log(element);
            alert(config.message);
        });
    }
});
