$(document).on('ready', function () {
//    // initialization of header
//    $.HSCore.components.HSHeader.init($('#js-header'));
//    $.HSCore.helpers.HSHamburgers.init('.hamburger');
//
//    // initialization of MegaMenu
//    $('.js-mega-menu').HSMegaMenu();

    // initialization of HSDropdown component
    $.HSCore.components.HSDropdown.init($('[data-dropdown-target]'), {
        afterOpen: function () {
            $(this).find('input[type="search"]').focus();
        }
    });

    // initialization of scroll animation
    $.HSCore.components.HSOnScrollAnimation.init('[data-animation]');

    // initialization of go to
    $.HSCore.components.HSGoTo.init('.js-go-to');

    // initialization of counters
    var counters = $.HSCore.components.HSCounter.init('[class*="js-counter"]');

    // initialization of carousel
    $.HSCore.components.HSCarousel.init('[class*="js-carousel"]');

    // initialization of popups
    $.HSCore.components.HSPopup.init('.js-fancybox');
    
    // initialization of HSScrollBar component
    $.HSCore.components.HSScrollBar.init( $('.js-scrollbar') );
});

$(window).on('load', function () {
    // initialization of header
    $.HSCore.components.HSHeader.init($('#js-header'));
    $.HSCore.helpers.HSHamburgers.init('.hamburger');
    
    // initialization of HSMegaMenu component
    $('.js-mega-menu').HSMegaMenu({
      event: 'hover',
      pageContainer: $('.container'),
      breakpoint: 991
    });
    
    // initialization of sticky blocks
    setTimeout(function () { // important in this case
        $.HSCore.components.HSStickyBlock.init('.js-sticky-block');
    }, 1);
});