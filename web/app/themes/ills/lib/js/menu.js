//ハンバーガーメニューのボタン
(function () {
  $('#js-buttonHamburger').click(function () {
    $('body').toggleClass('is-drawerActive');

    if ($(this).attr('aria-expanded') == 'false') {
      $(this).attr('aria-expanded', true);
    } else {
      $(this).attr('aria-expanded', false);
    }
  });

})();

//ハンバーガーメニューの設定
var navFlg = false;
$('#js-buttonHamburger').on('click', function () {
  $('.menu__line').toggleClass('active');
  $('.gnav').fadeToggle();
  if (!navFlg) {
    $('.gnav__menu__item').each(function (i) {
      $(this).delay(i * 0).animate({
        'opacity': 1,
      }, 0);
    });
    navFlg = true;
  } else {
    $('.gnav__menu__item').css({
      'opacity': 0,
    });
    navFlg = false;
  }
});


// スクロールイベント
var _window = $(window),
  _header = $('.l--header'),
  heroBottom;

_window.on('scroll', function () {
  heroBottom = $('.hero').height();
  if (_window.scrollTop() > heroBottom) {
    _header.addClass('transform');
  } else {
    _header.removeClass('transform');
  }
});

_window.trigger('scroll');
