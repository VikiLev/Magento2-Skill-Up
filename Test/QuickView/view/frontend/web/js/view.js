define([
    'jquery',
    'uiComponent',
    'ko',
    'Magento_Ui/js/modal/confirm',
    'Magento_Ui/js/modal/modal',
    'mage/url'
], function ($, Component, ko, confirmation, modal, urlBuilder) {
    'use strict';
    return Component.extend({
        defaults: {
            url: "",
            productSku: "",
        },
        initialize: function () {
            this._super();
        },


        confirmButton: function () {
            confirmation({
                title: $.mage.__('Quick View'),
                // content: this.getContent(this.getProduct()),
                content: this.getContent(),
                actions: {
                    confirm: function () {
                    },
                    cancel: function () {
                    },
                    always: function () {
                    }
                }
            });
        },

        getProduct: function () {
            let product = '';
            $.ajax({
                url: this.url,
                data: {sku: this.productSku},
                type: "GET",
                dataType: 'json',
                async: false,
                cache: false,
            }).done(function (data) {
                product = JSON.parse(data.product);
            });
            return product;
        },


        getContentDiv: function (product) {
            return '<div class="product-item-info">\n' +
                '    <div>Name: ' + product.name+ '</div>\n' +
                '    <div>SKU: ' + product.sku+ '</div>\n' +
                '    <div>ID: ' + product.entity_id+ '</div>\n' +
                '    <div>Price: ' + product.price+ '</div>\n' +
                '</div>'
        },

        getContent: function () {
            var elem = document.getElementById(this.productSku);
            var clone = elem.cloneNode(true);
            clone.id = this.productSku+'!';
            clone.setAttribute("style","display:block");
            return clone;
        },
        getProductImage: function (image) {
            return urlBuilder.build("media/catalog/product"+image);
        },
        addToCart: function (sku) {
            return "/view/index/addtocart?sku="+sku;
        },
    })
});
