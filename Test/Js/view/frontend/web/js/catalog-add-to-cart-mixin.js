
define([
    'jquery',
], function ($) {
    'use strict';

    return function (widget) {
        $.widget('mage.catalogAddToCart', widget, {

            /**
             * @param {jQuery} form
             */
            ajaxSubmit: function (form) {

                alert('Hello from Js MIXIN');
                this._super(form)
            }
        });

        return $.mage.catalogAddToCart;
    }
});
