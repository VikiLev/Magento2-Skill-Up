define([
    'jquery'
], function ($) {
    'use strict';

    return function (config) {

        console.log("test7");

        $('#store_reviews').submit(function() {
            var titleValue = $("input[name='title']").val();
            var reviewValue = $("input[name='review']").val();
            var prosValue = $("input[name='pros']").val();
            var consValue = $("input[name='cons']").val();

            console.log(titleValue);
            console.log(config.url);

            $.ajax({
                url: config.url,
                type: "POST",
                data: {title:titleValue,review:reviewValue,pros:prosValue,cons:consValue},
                showLoader: true,
                cache: false,
                success: function(){
                    console.log('success');
                }
            });
            return false;
        });
    }
});
