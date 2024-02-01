(function ($) {
    
    "use strict";

    $("form").attr("autocomplete", "off");

    $(".scroll-top").hide();
    $(window).on("scroll", function () {
        if ($(this).scrollTop() > 300) {
            $(".scroll-top").fadeIn();
        } else {
            $(".scroll-top").fadeOut();
        }
    });
    $(".scroll-top").on("click", function () {
        $("html, body").animate(
            {
                scrollTop: 0,
            },
            700
        );
    });

    new WOW().init();

    $(".video-button").magnificPopup({
        type: "iframe",
        gallery: {
            enabled: true,
        },
    });

    $(".magnific").magnificPopup({
        type: "image",
        gallery: {
            enabled: true,
        },
    });
    
    jQuery(".mean-menu").meanmenu({
        meanScreenWidth: "991",
    });

    $(document).ready(function () {
        $('#datatable').DataTable();
    });

    tinymce.init({
        selector: '.editor',
        height: '300'
    });

    $('.select2').select2();

    $(".testimonial-carousel").owlCarousel({
        loop: true,
        autoplay: true,
        autoplayHoverPause: true,
        autoplaySpeed: 1500,
        smartSpeed: 1500,
        margin: 30,
        nav: false,
        animateIn: "fadeIn",
        animateOut: "fadeOut",
        navText: [
            "<i class='fa fa-caret-left'></i>",
            "<i class='fa fa-caret-right'></i>",
        ],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1,
            },
            992: {
                items: 1,
            },
        },
    });

})(jQuery);