$('.my-tooltip').tooltip();
$(document).ready(function () {
    $(".totop").hide();

    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.totop').fadeIn();
        } else {
            $('.totop').fadeOut();
        }
    });
    $(".totop a").click(function (e) {
        e.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        return false;
    });

    jQuery('.tp-banner').revolution({
        delay: 9000,
        startheight: 500,

        hideThumbs: 10,

        navigationType: "bullet",


        hideArrowsOnMobile: "on",

        touchenabled: "on",
        onHoverStop: "on",

        navOffsetHorizontal: 0,
        navOffsetVertical: 20,

        stopAtSlide: -1,
        stopAfterLoops: -1,

        shadow: 0,

        fullWidth: "on",
        fullScreen: "off"
    });


    $('.flexslider-recent').flexslider({
        animation: "fade",
        animationSpeed: 1000,
        controlNav: true,
        directionNav: false
    });
    $('.flexslider-testimonial').flexslider({
        animation: "fade",
        slideshowSpeed: 5000,
        animationSpeed: 1000,
        controlNav: true,
        directionNav: false
    });

    jQuery(".gallery-img-link").prettyPhoto({
        overlay_gallery: false,
        social_tools: false
    });
    
    // Form validation
    $.validate({borderColorOnError : '#ebccd1', 
                validateOnBlur : true,
                showHelpOnFocus : true,
                addSuggestions : true,
                onSuccess: function(){}});
});