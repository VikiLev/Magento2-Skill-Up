
define([
    'uiComponent',
    'jquery'
], function (Component, $) {
    'use strict';

    return Component.extend({
        defaults: {
            // template: 'Test_Ui/ui'
            outText: 'text from ui',
            outTextButton: 'text from ui for button',
            textFromPhp: ''
        },

        /**
         * @override
         */
        initialize: function () {
            this._super();
            console.log('initialized Child');
            return this;
        },

        clickButton: function () {
            alert(this.outTextButton);
        },

        clickButton2: function () {
            alert(this.textFromPhp);
        }

    });
});
