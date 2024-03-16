//単体でフェードインさせる
$(function () {
  $(window).scroll(function () {
    var fadeTrigger = $('.js-trigger');
    $(fadeTrigger).each(function () {
      var scroll = $(window).scrollTop(),
        elemTop = $(this).offset().top,
        windowHeight = $(window).height();

      if (scroll > elemTop - windowHeight + 150) {
        $(this).addClass('fade-scale');
      }
    });
  });
  $(window).trigger('scroll');
});


//一斉にフェードインさせる
$(function () {
  $(window).scroll(function () {
    var fadeTrigger = $('.js-trigger');
    $(fadeTrigger).each(function () {
      var scroll = $(window).scrollTop(),
        elemTop = $(this).offset().top,
        windowHeight = $(window).height();

      if (scroll > elemTop - windowHeight + 150) {
        $(this).find('.fade-elem').addClass('fade-up');
      }
    });
  });
  $(window).trigger('scroll');
});


//複数パターンの実装
$(function () {
  $(window).scroll(function () {
    var fadeTrigger = $('.js-trigger');
    $(fadeTrigger).each(function () {
      var scroll = $(window).scrollTop(),
        elemTop = $(this).offset().top,
        windowHeight = $(window).height();

      if (scroll > elemTop - windowHeight + 150) {
        if ($(this).hasClass('multi-trigger')) {
          $(this).find('.fade-elem').addClass('fade-up-down');
        } else if ($(this).hasClass('fade-type-up') || $(this).hasClass('fade-type-down')) {
          $(this).addClass('fade-up-down');
        } else if ($(this).hasClass('fade-type-left') || $(this).hasClass('fade-type-right')) {
          $(this).addClass('fade-left-right');
        }
      }
    });
  });
  $(window).trigger('scroll');
});
