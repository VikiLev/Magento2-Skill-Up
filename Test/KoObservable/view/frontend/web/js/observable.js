
define([
    'uiComponent',
    'jquery',
    'ko'
], function (Component, $, ko) {
    'use strict';

    return Component.extend({
        defaults: {
            diceUrl: "",
            diceNumber: 0,
            canShow: 0,
            // diceNumber: ko.observable(1),
            // canShow: ko.observable(1)
        },

        /**
         * @override
         */
        initialize: function () {
            this._super();
            console.log('test observable');
            return this;
        },

        initObservable: function () {
            this._super()
                .observe('diceNumber')
                .observe('canShow')
            return this;
        },

        clickButton: function () {
            let self = this;
            $.ajax({
                url: this.diceUrl,
                context: this,
                cache: false,
                dataType: 'JSON',
            }).done(function (data) {

                console.log(self.diceNumber)
                console.log(self.canShow)
                console.log("diceNumber before:" + self.diceNumber())
                console.log("canShow before:" + self.canShow())

                if (data.diceNumber){
                    // self.diceNumber =  data.diceNumber;
                    // self.canShow =  data.canShow;
                    self.diceNumber(data.diceNumber);
                    self.canShow(data.canShow);
                }
                console.log("diceNumber before:" + self.diceNumber())
                console.log("canShow before:" + self.canShow())
            });
        }
    });
});
