
define([
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'mage/translate',
], function (Component, customerData, $t) {
    'use strict';


    return Component.extend({
        /** @inheritdoc */
        initialize: function () {
            this._super();
            this.freeShippingData = customerData.get('freeshipping');
        }
    });
});
