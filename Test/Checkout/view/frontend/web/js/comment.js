
define([
    'uiComponent'
], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            placeholder: "lala"
        },

        /**
         * @override
         */
        initialize: function () {
            this._super();
            console.log('checkoutComment');
            return this;
        }
    });
});
