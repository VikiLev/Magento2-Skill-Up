define([
    'jquery',
    'uiComponent',
    'ko',
], function ($, Component, ko) {
    'use strict';

    return Component.extend({
        defaults: {
            url: "",
            productId: ko.observable(),
            nickNameValue: ko.observable(""),
            reviewValue: ko.observable(""),
            titleValue: ko.observable(""),
            reviews: '',
        },

        initObservable: function () {
            this._super()
                .observe('reviews')
            return this;
        },

        initialize: function () {
            this._super();
            return this;
        },
        submitReview: function () {
            let self = this;
            $.ajax({
                url: this.url,
                type: "POST",
                data: {nickName:this.nickNameValue(), review:this.reviewValue(), title:this.titleValue, productId:this.productId},
                showLoader: false,
                cache: false,
            }).done(function (data) {
                let allREviews = JSON.parse(data['reviews']);
                self.reviews.unshift(allREviews[0]);
                $('input[type="text"],textarea').val('');
            });
        },
    });
});
