define([
    'jquery',
    'uiComponent',
    'ko',
    'slick'
], function ($, Component, ko) {
    'use strict';

    return Component.extend({
        defaults: {
            banners: '',
        },

        initialize: function () {
            this._super();
        },

        initializeBannerSlider: function () {
            $('.banner-slider').slick({
                dots: true,
                infinite: true,
                slidesToShow: 2,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                speed: 500,
                pauseOnHover: true,
                accessibility: true
            });
        },
    });
});
