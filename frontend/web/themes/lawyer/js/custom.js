// initialization of google map
function initMap() {
    $.HSCore.components.HSGMap.init('.js-g-map');
}

// initialization of revolution slider
var tpj = jQuery,
        promoSlider;

tpj(document).on('ready', function () {
    if (tpj('#promoSlider').revolution == undefined) {
        revslider_showDoubleJqueryError('#promoSlider');
    } else {
        promoSlider = tpj('#promoSlider').show().revolution({
            sliderType: 'hero',
            jsFileLocation: '../../revolution/js/',
            sliderLayout: 'fullwidth',
            dottedOverlay: 'none',
            delay: 9000,
            navigation: {},
            responsiveLevels: [1240, 1024, 778, 480],
            gridwidth: [1240, 1024, 778, 480],
            gridheight: [600, 500, 400, 300],
            lazyType: 'none',
            parallax: {
                type: 'mouse',
                origo: 'slidercenter',
                speed: 2000,
                levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50]
            },
            shadow: 0,
            spinner: 'off',
            autoHeight: 'off',
            disableProgressBar: 'on',
            hideThumbsOnMobile: 'off',
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: 'off',
                disableFocusListener: false
            }
        });
    }
});

$(document).on('ready', function () {
    // initialization of carousel
    $.HSCore.components.HSCarousel.init('.js-carousel');

    // initialization of header
    $.HSCore.components.HSHeader.init($('#js-header'));
    $.HSCore.helpers.HSHamburgers.init('.hamburger');

    // initialization of go to section
    $.HSCore.components.HSGoTo.init('.js-go-to');
});

$(window).on('load', function () {
    // initialization of HSScrollNav
    $.HSCore.components.HSScrollNav.init($('#js-scroll-nav'), {
        duration: 700
    });
});