define([
    'jquery',
    'jquery-ui-modules/widget'
], function ($) {
    'use strict';

    $.widget('mage.customWidget', {
        options: {
            'message' : 'Clicked'
        },

        _create: function () {
            this._bindClick();
        },

        _bindClick: function () {
            var self = this;
            $('#btn_click_4').click(function () {
                alert(self.options.message);
            });
        }
    });

    return $.mage.customWidget;
});
