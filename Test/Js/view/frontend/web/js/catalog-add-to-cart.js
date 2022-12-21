
define([
    'jquery',
    'Magento_Catalog/js/catalog-add-to-cart',
    'jquery-ui-modules/widget'
], function ($, catalogAddToCart) {
    'use strict';

    $.widget('mage.catalogAddToCart', catalogAddToCart, {

        /**
         * @param {jQuery} form
         */
        ajaxSubmit: function (form) {

            alert('Hello from Js new');
            this._super(form)
        }
    });

    return $.mage.catalogAddToCart;
});
