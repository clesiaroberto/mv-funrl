/****************************************************************
 *   Author : Elton Bruno Cidjoto
 *   Version : v.1.0.0
 *   Created : 2021-04-15
****************************************************************/

(function ($, window, document) {
  var Slider = {
    init : function (options, el) {
      var base = this;

      base.$elem = $(el);
      base.options = $.extend({}, $.fn.runSlider.options, base.$elem, options);

      base.userOptions = options;
      base.createBullets();
    },

    createBullets: function() {
      var base = this, url;

      for (var i = 0; i < base.options.numOfSlides + 1; i++) {
        var $li = $("<li class='slider-dotted-control'></li>");
        $li.addClass("slider-dotted-control-"+i).data("page", i);
        if (!i) $li.addClass("active");
        base.options.pagination.append($li);
      }

      base.autoSlide();
      base.touchandle()
    },

    manageControls: function() {
      var base = this;

      $(".slider-control").removeClass("inactive");
      if (!base.options.curSlide) $(".slider-control.left").addClass("inactive");
      if (base.options.curSlide === base.options.numOfSlides) $(".slider-control.right").addClass("inactive");
    },

    autoSlide: function() {
      var base = this;

      base.options.autoSlideTimeout = setTimeout(function() {
        base.options.curSlide++;
        if (base.options.curSlide > base.options.numOfSlides) base.options.curSlide = 0;
        base.changeSlides();
      }, base.options.autoSlideDelay);
    },

    changeSlides: function(instant) {
      var base = this;

      if (!instant) {
        base.options.animating = true;
        base.manageControls();
        base.options.slider.addClass("animating");
        base.options.slider.css("top");
        $(".slide").removeClass("active");
        $(".slide-"+base.options.curSlide).addClass("active");
        setTimeout(function() {
          base.options.slider.removeClass("animating");
          base.options.animating = false;
        }, base.options.animTime);
      }
      window.clearTimeout(base.options.autoSlideTimeout);
      $(".slider-dotted-control").removeClass("active");
      $(".slider-dotted-control-"+base.options.curSlide).addClass("active");
      base.options.slider.css("transform", "translate3d("+ -base.options.curSlide*100 +"%,0,0)");
      base.options.slideBGs.css("transform", "translate3d("+ base.options.curSlide*50 +"%,0,0)");
      base.options.diff = 0;
      base.autoSlide();
    },

    navigateLeft: function() {
      var base = this;

      if (base.options.animating) return;
      if (base.options.curSlide > 0) base.options.curSlide--;
      base.changeSlides();
    },

    navigateRight: function() {
      var base = this;

      if (base.options.animating) return;
      if (base.options.curSlide < base.options.numOfSlides) base.options.curSlide++;
      base.changeSlides();
    },

    touchandle: function() {
      var base = this;
  
      $(`.${base.$elem.eq(0).attr('class')}`).on("mousedown touchstart", function(e) {
        if (base.options.animating) return;
        window.clearTimeout(base.options.autoSlideTimeout);
        var startX = e.pageX || e.originalEvent.touches[0].pageX,
            winW = $(window).width();
        base.options.diff = 0;
        
        $(document).on("mousemove touchmove", function(e) {
          var x = e.pageX || e.originalEvent.touches[0].pageX;
          base.options.diff = (startX - x) / winW * 70;
          if ((!base.options.curSlide && base.options.diff < 0) || (base.options.curSlide === base.options.numOfSlides && base.options.diff > 0)) base.options.diff /= 2;
          base.options.slider.css("transform", "translate3d("+ (-base.options.curSlide*100 - base.options.diff) +"%,0,0)");
          base.options.slideBGs.css("transform", "translate3d("+ (base.options.curSlide*50 + base.options.diff/2) +"%,0,0)");
        });
      });

      $(document).on("mouseup touchend", function(e) {
        $(document).off("mousemove touchmove");
        if (base.options.animating) return;
        if (!base.options.diff) {
          base.changeSlides(true);
          return;
        }
        if (base.options.diff > -8 && base.options.diff < 8) {
          base.changeSlides();
          return;
        }
        if (base.options.diff <= -8) {
          base.navigateLeft();
        }
        if (base.options.diff >= 8) {
          base.navigateRight();
        }
      });

      $(document).on("click", ".slider-control", function() {
        if ($(this).hasClass("left")) {
          base.navigateLeft();
        } else {
          base.navigateRight();
        }
      });
      
      $(document).on("click", ".slider-dotted-control", function() {
        base.options.curSlide = $(this).data("page");
        base.changeSlides();
      });
    }
  };

  $.fn.runSlider = function (options) {
    return this.each(function () {
      var slider = Object.create(Slider);
      slider.init(options, this);
      $.data(this, slider);
    });
  };

  $.fn.runSlider.options = {
    slider : 0,
    slideBGs : 0,
    diff : 0,
    curSlide : 0,
    numOfSlides : 0,
    animating : false,
    animTime : 500,
    autoSlideTimeout : 6000,
    autoSlideDelay : 6000,
    pagination : 0
  };
}(jQuery, window, document));


$(document).ready(function() {
  // Carousel to page index.php
  var slide = $('.slider').runSlider({
    slider : $(".slider"),
    slideBGs : $(".bg-slide"),
    numOfSlides: $(".slide").length - 1,
    pagination : $(".slider-dotted")
  });

  // Carousel to page index and all page of the centers
  var owl = $('#owl-company');
  owl.owlCarousel({
    items:6,
    loop:true,
    margin:10,
    lazyLoad:true,
    animateOut: 'fadeOut',
    pagination: false,
    autoPlay: true,
    autoPlaySpeed: 1,
    autoPlayTimeout: 1,
    responsiveClass:true,
    responsive:{
      0:{
        items:1,
        nav:true
      },
      600:{
        items:3,
        nav:false
      },
      1000:{
        items:5,
        nav:true,
        loop:false
      }
    }
  });
});