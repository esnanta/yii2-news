$(document).on('ready', function () {
  // initialization of go to
  $.HSCore.components.HSGoTo.init('.js-go-to');

  // initialization of tabs
  $.HSCore.components.HSTabs.init('[role="tablist"]');
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

  // initialization of cubeportfolio
  $.HSCore.components.HSCubeportfolio.init('.cbp');
});

$(window).on('resize', function () {
  setTimeout(function () {
    $.HSCore.components.HSTabs.init('[role="tablist"]');
  }, 200);
});