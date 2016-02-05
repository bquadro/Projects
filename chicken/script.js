/*!
 * IE10 viewport hack for Surface/desktop Windows 8 bug
 * Copyright 2014-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

// See the Getting Started docs for more information:
// http://getbootstrap.com/getting-started/#support-ie10-width

(function () {
  'use strict';

  if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement('style')
    msViewportStyle.appendChild(
      document.createTextNode(
        '@-ms-viewport{width:auto!important}'
      )
    )
    document.querySelector('head').appendChild(msViewportStyle)
  }

})();

(function($){

  //События кнопок в шапке
  $(document).ready(function(){
    $("#b-navbar").on("hidden.bs.collapse", function(){
      console.log('close');
      $('.toggle-buttons').removeClass('active-nav');
    });
    $("#b-navbar").on("show.bs.collapse", function(){
      console.log('open');
      $('.toggle-buttons').addClass('active-nav');
    });
    $("#b-search").on("hidden.bs.collapse", function(){
      console.log('close');
      $('.toggle-buttons').removeClass('active-search');
    });
    $("#b-search").on("show.bs.collapse", function(){
      console.log('open');
      $('.toggle-buttons').addClass('active-search');
    });
  });
  
  //каталог на стартовой
  function catalogfront(){
    var noresize = parseInt($(window).width()) < 768;
    var margintop = noresize ? 0 : parseInt($('#b-catalog-front .b-catalog-item:eq(0)').height());
    $('#b-catalog-front').css('margin-top', -1 * margintop);
  }
  
  //поиск на стартовой
  function searchfront(){
    var noresize = parseInt($(window).width()) < 992;
    var margintop = noresize ? 0 : parseInt($('#b-search-front #b-search-index-square-content').height());
    $('#b-search-front').css('margin-top', -1 * margintop);
    $('#b-search-index-form').submit(function(){
      if(!$('#b-search-front .b-search-index-submit').hasClass('collapsed') && !noresize) return false;
    });
  }

  $(window).load(catalogfront);
  $(window).resize(catalogfront);
  $(window).load(searchfront);
  $(window).resize(searchfront);
  
  //каталог на стартовой
  function catcols(){

    //$('#catalog2-front .cat-col').once().wrapInner("<div class='wrap'></div>");
    var lvl = parseInt($(window).width()) >= 768 ? '1' : '2';
    var noresize = parseInt($(window).width()) < 480;
    if(noresize) {
      $('#catalog2-front .cat-col').height('auto');
      return;
    }
    $('#catalog2-front .cat-row-lvl'+lvl).each(function(){
      $('.cat-col', this).height('auto');
      var maxh = 0;
      $('.cat-col', this).each(function(){
        var h = parseInt($('.b-teaser', this).height()) + parseInt($('.b-teaser', this).css('marginTop')) + parseInt($('.b-teaser', this).css('marginBottom'));
        if(h > maxh) maxh = h;
      });
      $('.cat-col', this).height(maxh);
    });
  }
  
  $(window).load(catcols);
  $(window).resize(catcols);
  
  //Контакты
  function contactcols(){
    //$('#catalog2-front .cat-col').once().wrapInner("<div class='wrap'></div>");
    var noresize = parseInt($(window).width()) < 768;
    if(noresize) {
      $('#b-contacts .b-contacts-col').height('auto');
      return;
    }
    $('#b-contacts .row').each(function(){
      $('.b-contacts-col', this).height('auto');
      var maxh = 0;
      $('.b-contacts-col', this).each(function(){
        var h = parseInt($(this).outerHeight());
        if(h > maxh) maxh = h;
      });
      $('.b-contacts-col', this).height(maxh);
    });
  }
  
  $(window).load(contactcols);
  $(window).resize(contactcols);
  
  //Категории на стартовой
  function categorySquares(){
    
    $('#b-catalog-front').prepend('<div class="hidden"></div>');
    $('#b-catalog-front').prepend('<div class="visible"></div>');
    
    collapse();
    
    function collapse(){
      $('#b-catalog-front').addClass('collapsed');
      var visible = $('#b-catalog-front .b-catalog-item:lt(7)').not('.category-toogle');
      var hidden = $('#b-catalog-front .b-catalog-item:gt(6)').not('.category-toogle');
      var toggler = $('#b-catalog-front .b-catalog-item.category-toogle');
      $('#b-catalog-front .visible').append(visible);
      $('#b-catalog-front .visible').append(toggler);
      $('#b-catalog-front .hidden').append(hidden);
      toggler.find('.category-name').html('Смотреть<br>остальные');
    }
    
    function open(){
      $('#b-catalog-front').removeClass('collapsed');
      var visible = $('#b-catalog-front .b-catalog-item').not('.category-toogle');
      var toggler = $('#b-catalog-front .b-catalog-item.category-toogle');
      $('#b-catalog-front .visible').append(visible);
      $('#b-catalog-front .visible').append(toggler);
      toggler.find('.category-name').html('Показать<br>основные');
    }
    
    $('#b-catalog-front .b-catalog-item.category-toogle').click(function(){
      if($('#b-catalog-front').hasClass('collapsed')){
        open();
      } else {
        collapse();
      }
      return false;
    });
  }
  
  $(document).ready(categorySquares);
  
  //Ретэйлеры
  function retailersSquares(){
    
    var logoSlider=null;
    
    $('#retailers-front-logos-area').prepend('<div class="hidden"></div>');
    $('#retailers-front-logos-area').prepend('<div class="visible clearfix"></div>');
    
    var category_id = $('#retailers-front .retailer-groups a.active') ? $('#retailers-front .retailer-groups a.active').data('category-id') : $('#retailers-front .retailer-groups a:eq(0)').data('category-id');
    
    retsort(category_id);
    
    function retsort(category_id){
      var visible = $('#retailers-front-logos-area .retailer-item[data-category-id = '+category_id+']');
      var hidden = $('#retailers-front-logos-area .retailer-item[data-category-id != '+category_id+']');
      $('#retailers-front-logos-area .visible').html('');
      $('#retailers-front-logos-area .hidden').html('');

      var rowLen = 3;
      var visLen = visible.length;
      var rows = Math.ceil(visLen/rowLen);
      for(var j=0;j<rows;j++){
        var slide = $('<div class="slide clearfix"></div>');
        for(var i = j*rowLen;i<(j+1)*rowLen;i++){
          if(typeof visible[i] != 'undefined') slide.append(visible[i]);
        }
        $('#retailers-front-logos-area .visible').append(slide);
      }

      $('#retailers-front-logos-area .hidden').append(hidden);
      
      $('#retailers-front .retailer-groups a').removeClass('active');
      $('#retailers-front .retailer-groups a[data-category-id = '+category_id+']').addClass('active');
      
      if(logoSlider) {
        logoSlider.destroySlider();
        logoSlider = null;
      }
     
      if($('#retailers-front-logos-area .visible .slide').length > 2){
        logoSlider = $('#retailers-front-logos-area .visible').bxSlider({
          'mode': 'vertical',
          'pager' : false,
          'minSlides': 2,
          'maxSlides': 2,
          'moveSlides': 1,
          'infiniteLoop':false
        });
      }

    }

    $('#retailers-front .retailer-groups a').click(function(){
        retsort($(this).data('category-id'));
        return false;
    });
  }
  
  $(document).ready(retailersSquares);				
  
  // Кнопка скролл наверх
  var scrollTimeout = 1;
  $.fn.liScrollToTop = function(params) {
  		return this.each(function() {
  				var scrollUp = $(this);
  				scrollUp.hide();
  				if(parseInt($(window).width()) < 768) return;
  				if ($(window).scrollTop() > 0)
  						scrollUp.fadeIn("slow")
  				$(window).scroll(function() {
  						if (scrollTimeout) {
  								scrollTimeout = 0;
  								window.setTimeout(function() {
  										scrollTimeout = 1;
  								}, 10);
  								var $body = parseInt($('body').height());
  								var $window = parseInt($(window).height());
  								$flimit = $body - parseInt($(window).scrollTop()) - $window;
  								//console.log($flimit);
  								//if($flimit > 0) {
  								//scrollUp.css('bottom', 90);
  								//} else {
  								//  scrollUp.css('bottom', 50-$flimit);
  								//}
  						}
  						scrollUp
  						if ($(window).scrollTop() <= 0)
  								scrollUp.fadeOut('slow')
  						else
  								scrollUp.fadeIn("slow");
  				});
  				scrollUp.click(function() {
  						$("html, body").animate({scrollTop: 0}, "slow");
  						window.location.hash = '';
  				})
  		});
  };
    
  $(document).ready(function(){
    $('.scrollUp').liScrollToTop();
  });	
  				
  //карты яндекса
  function ymaps_init() {
    // Создание экземпляра карты и его привязка к контейнеру с
    // заданным id ("map")
    $('.yamaps').each(function(){
      var d = $(this);
      d.html('');
      render(d.attr('id'), d.data('center'), d.data('placemarks'), d.data('text'));
    });
    
    function render(id, center, placemarks, content){
      content = content.replace(/'/g, '"');
      content = JSON.parse(content);
      var myMap = new ymaps.Map(id, {
        // При инициализации карты, обязательно нужно указать
        // ее центр и коэффициент масштабирования
        center: center, // Нижний Новгород
        zoom: 9
      });
      
      // Создание экземпляра элемента управления
      myMap.controls.add(
         new ymaps.control.ZoomControl()
      );
      for(var i=0;i < placemarks.length;i++){
        var placemark = placemarks[i];
        var text = content[i];
        // Создание метки 
        var myPlacemark = new ymaps.Placemark(
          // Координаты метки
          placemark, {
            balloonContent: text
          }, {
            iconImageHref: 'img/marker.png',
            iconImageSize: [26, 36],
            iconImageOffset: [-13, -36]
          }      
        );
        // Добавление метки на карту
        myMap.geoObjects.add(myPlacemark);
      }
    }
  }

  ymaps.ready(ymaps_init);
  
  //слайдер на стартовой  
  function sliderfront(){
    if($('#slider-front').length && $.fn.camera){
      $('#slider-front .camera_wrap').camera({
    				pagination: false,
    				thumbnails: false,
    				height: '32%',
    				minHeight: '780px',
    				pieDiameter: 112,
    				piePosition: 'rightTop',
    				loaderColor: '#c65043',
            loaderBgColor: '#ffffff',
            loaderPadding: -.5,
            loaderOpacity: 1,
            loaderStroke: 3,
            fx: 'simpleFade',
            playPause: false,
            pauseOnClick: false,
            overlayer: false,
            hover: false,
            navigationHover: false,
            mobileNavHover: false,
            onStartLoading: function() {
              $('#slider-front').once(function () {
                $('#slider-front .camera_fakehover').append('<div class="camera_navigation"><div class="container"><div class="cont"></div></div></div>');
                $('#slider-front .camera_navigation .cont')
                  .append($('#slider-front .camera_wrap .camera_pie'))
                  .append($('#slider-front .camera_wrap .camera_prev'))
                  .append($('#slider-front .camera_wrap .camera_next'));
                  $('#slider-front .camera_wrap .camera_pie').append('<div class="pie_digits"></div>');
              });
            },
            onEndTransition: function(){
              var slideCount = $('#slider-front .camera_wrap .camera_src .slider-item').length;
              var ind = $('#slider-front .camera_wrap .cameraSlide.cameracurrent').index();
              var cur = ind + 1;
              $('#slider-front .camera_wrap .camera_pie .pie_digits').html(cur + '/'+slideCount);
            }
      });
    }
  }
  
  $(document).ready(sliderfront);	  
  
  //слайдер галереи
  var sliderGallery;
  function slidergallery(){
    sliderGallery = $('.gallery').bxSlider({
      mode: 'horizontal',
     // 'pager' : false
    });
  }
  
  $(document).ready(slidergallery);	    
  
  $(document).ready(function() {
		$(".fancybox-ajax").fancybox({'onComplete':function(){$('.fancybox-type-ajax input, .fancybox-type-ajax textarea').placeholder();}});
	});
	
  function photogallery(){
    $('.photogallery').once(function() {
      $('.photogallery .b-img a').append('<span class="zoom-thumb"><span class="glyphicon glyphicon-search"></span></span>');
    });
    
    $(".photogallery a").fancybox({
      helpers: {
        overlay: {
          locked: false
        }
      }
  	});
  }
  
  $(document).ready(photogallery);	    
		
    
})(jQuery);
