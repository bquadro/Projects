/*! js-cookie v2.1.0 | MIT */
!function(a){if("function"==typeof define&&define.amd)define(a);else if("object"==typeof exports)module.exports=a();else{var b=window.Cookies,c=window.Cookies=a();c.noConflict=function(){return window.Cookies=b,c}}}(function(){function a(){for(var a=0,b={};a<arguments.length;a++){var c=arguments[a];for(var d in c)b[d]=c[d]}return b}function b(c){function d(b,e,f){var g;if(arguments.length>1){if(f=a({path:"/"},d.defaults,f),"number"==typeof f.expires){var h=new Date;h.setMilliseconds(h.getMilliseconds()+864e5*f.expires),f.expires=h}try{g=JSON.stringify(e),/^[\{\[]/.test(g)&&(e=g)}catch(i){}return e=c.write?c.write(e,b):encodeURIComponent(String(e)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),b=encodeURIComponent(String(b)),b=b.replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent),b=b.replace(/[\(\)]/g,escape),document.cookie=[b,"=",e,f.expires&&"; expires="+f.expires.toUTCString(),f.path&&"; path="+f.path,f.domain&&"; domain="+f.domain,f.secure?"; secure":""].join("")}b||(g={});for(var j=document.cookie?document.cookie.split("; "):[],k=/(%[0-9A-Z]{2})+/g,l=0;l<j.length;l++){var m=j[l].split("="),n=m[0].replace(k,decodeURIComponent),o=m.slice(1).join("=");'"'===o.charAt(0)&&(o=o.slice(1,-1));try{if(o=c.read?c.read(o,n):c(o,n)||o.replace(k,decodeURIComponent),this.json)try{o=JSON.parse(o)}catch(i){}if(b===n){g=o;break}b||(g[n]=o)}catch(i){}}return g}return d.get=d.set=d,d.getJSON=function(){return d.apply({json:!0},[].slice.call(arguments))},d.defaults={},d.remove=function(b,c){d(b,"",a(c,{expires:-1}))},d.withConverter=b,d}return b(function(){})});

function sendEvent(event, category, virtual) {
    var c = typeof console !== "undefined";
		if (event == "")
				return;
		if (typeof category == "undefined")
				category = 'form';
		if (typeof yaCounter29322070 !== "undefined"){
				yaCounter29322070.reachGoal(event);
  		if (c)
  			console.log("yaCounter29322070.reachGoal('"+event+"');");				
		}
		if (typeof _gaq !== "undefined"){
				_gaq.push(['_trackEvent', category, event]);
  		if (c)
  				console.log("_gaq.push(['_trackEvent', '"+category+"', '"+event+"']);");				
  	}
		if (typeof ga !== "undefined"){
      if(typeof virtual !== "undefined"){ 
        ga('send', 'pageview', virtual) 
    		if (c)
    				console.log("ga('send', 'pageview', '"+virtual+"');");
      } 
			ga('send', 'event', category, event); 
  		if (c)
  				console.log("ga('send', 'event', '"+category+"', '"+event+"');");
		}
		return true;
}

//email select event

if(!window.Kolich){
  Kolich = {};
}

Kolich.Selector = {};
Kolich.Selector.getSelected = function(){
  var t = '';
  if(window.getSelection){
    t = window.getSelection();
  }else if(document.getSelection){
    t = document.getSelection();
  }else if(document.selection){
    t = document.selection.createRange().text;
  }
  t = t.toString().replace(/^\s+/,'');
  t = t.replace(/\s+$/,'');
  return t;
}

Kolich.Selector.mouseup = function(){
  var st = Kolich.Selector.getSelected();
  if(st!=''){
	var re = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    if(re.test(st)){
      sendEvent('adress', 'contact');
    }
  }
}

$(document).bind("mouseup", Kolich.Selector.mouseup);

function ymaps_init() {
  // Создание экземпляра карты и его привязка к контейнеру с
  // заданным id ("map")
  $('.yamaps').each(function(){
    var d = $(this);
    var content = d.html();
    d.html('');
    render(d.attr('id'), d.data('center'), d.data('placemark'), content);
  });
  
  function render(id, center, placemark, content){
    var myMap = new ymaps.Map(id, {
      // При инициализации карты, обязательно нужно указать
      // ее центр и коэффициент масштабирования
      center: center, // Нижний Новгород
      zoom: 16
    });
    
    // Создание экземпляра элемента управления
    myMap.controls.add(
       new ymaps.control.ZoomControl()
    );
    
    // Создание метки 
    var myPlacemark = new ymaps.Placemark(
      // Координаты метки
      placemark, {
        balloonContent: content
      }, {
        iconImageHref: '/bitrix/templates/domamo_v1/images/marker-map.png',
        iconImageSize: [52, 74],
        iconImageOffset: [-26, -74]
      }      
    );
    
    // Добавление метки на карту
    myMap.geoObjects.add(myPlacemark);
  }
}

ymaps.ready(ymaps_init);
 
$(document).ready(function () {
  // Как только будет загружен API и готов DOM, выполняем инициализацию
 

		/*head*/
		$(".city_select .city_active").click(function () {
				$(this).parent().addClass("active");
		});
		$(".city_select").mouseleave(function () {
				$(this).removeClass("active");
		});
		$(".top_header .top_header_ul li, .footer .top_header_ul li").click(function () {
				$(".top_header .city_active, .footer .city_active").html($(this).html());
				$(".tel").html($(this).data("phone"));
				$(this).parents(".city_select").removeClass("active");
				$(".top_header_ul .active").removeClass("active");
				$(".top_header_ul ."+$(this).attr("class")).addClass("active");
				return false;
		});
		$("html").click(function (e) {
				var clicked = jQuery(e.target);
				//выбор города
				if (clicked.parents(".city_select").size() == 0) {
						$(".city_select").removeClass("active");
				}				
				//Подсказка в фильтре
				if (clicked.parents(".bx_filter_popup_result").size() == 0 && clicked.parents(".r_filtr").size()==0) {
						$(".bx_filter_popup_result").hide();
				}				
		});
		
		
		/*Формы на сайте*/
		$(".cell_form").click(function(){
				$.fancybox.showLoading();
				$.post("/ajax/cell_form.php",{},function(html){
						$.fancybox({content: html, padding: 0});
						$.fancybox.hideLoading();
				}, "html" );
				return false;
		});
		$(".quest_form").click(function(){
				$.fancybox.showLoading();
				var id = $(this).data("id");			
				$.post("/ajax/quest_form.php",{productID: id},function(html){
						$.fancybox({content: html, padding: 0});
						$.fancybox.hideLoading();
				}, "html" );
				return false;
		});				
				
		$(".add2basket").click(function(){
				$.fancybox.showLoading();
				var id = $(this).data("id");				
				$.post("/ajax/order_form.php",{productID: id},function(html){
						$.fancybox({content: html, padding: 0});
						$.fancybox.hideLoading();
				}, "html" );
				return false;
		});


		$(".b_search .search_text").focus(function () {
				$(this).parents(".b_search").addClass("focus");
		});
		
		$(".b_search .search_text").blur(function () {
				$(this).parents(".b_search").removeClass("focus");
				if ($(this).val() === "") {
						$(this).parents(".b_search").removeClass("query");
				} else {
						$(this).parents(".b_search").addClass("query");
				}
		});
		
		//Подсказка
		$( ".b_tech_param .q").each(function () {
				if($(this).data("text") != ""){
						$(this).tooltipster({
								content: "<div class='t_text'>" + $(this).data("text")+'</div><div class="t_close"></div>',
								contentAsHTML: true,
								maxWidth: 460,
								interactive: true,
								interactiveTolerance: 130,
								onlyOne: true,
								offsetX: 15,
								offsetY: -25,
								//trigger: "click", //  <-- debug html
								//hideOnClick: true
						});
				}
		});

		$( ".b_tech_param .q").click(function(){				
				//$.tooltipster.hide();
				return false;
		});	

		//Планы, фасады и т.п.
		$("a.fancybox_img").fancybox({
				prevEffect : 'none',
				nextEffect : 'none',
				openEffect  : 'none',
				closeEffect : 'none',
				helpers:{
						title: {
								type: 'inside',
								position: "top"
						}
				}
		});

		//Загрузка сравнения
    loadFavorite();
    
		//Избранное
    $(".projects_heart").click(function() {
      return favoriteClickHandler($(this));
    });  	

		//Для названий в вариантах проекта, потом переверстать! #FIX
		$(".projects .item_block .b_name").click(function(){
				window.location =  $(this).parent().find("a.item").attr("href");
				return false;
		});
			
		$("body").on("click", ".t_close", function(){
				$(".tooltipster-default").remove();
		});				
		
});

function favoriteClickHandler(obj){
		 obj.toggleClass("active");
      var id = obj.data("rel");
      if (!obj.hasClass("active")) {            
        var query = {id:id, 'del':'Y'};
      } else {
        var query = {id:id};
      }
      BX.ajax.loadJSON("/ajax/favorites.php",
      query, 
      function(data){ 
        updateFavoriteBlock(data);
        showFavoriteMsg(data); 
      });
		 return false;
}

//Заказ строительства
function add2basketclick(el){
	var id = $(el).data("id");
	$.fancybox.showLoading();			
	$.post("/ajax/order_form.php",{productID: id},function(html){
			$.fancybox({content: html, padding: 0});
			$.fancybox.hideLoading();
	}, "html" );
	return false;
}

//Добавление в корзину
function add2cartclick(el){
	var id = $(el).data("id");
	$.fancybox.showLoading();
	$.post("/ajax/add2cart.php", {"id": id, q: 1}, function(html) {
			$.fancybox.hideLoading();
			$.fancybox({content: html});
	}, "html");
	//sendEvent($(this).data("event"), true);
	return false;
}

$(document).ready(function () {
		porject_resize();
		porject_set_clear();
		
		$(".mini-cart-holder").load("/ajax/basket.php");
		
    //Добавление в корзину (Альтернативная версия)
		$(".add2cart").click(function() {
				var id = $(this).data("id");
				$.fancybox.showLoading();
				$.post("/ajax/add2cart.php", {"id": id, q: 1}, function(html) {
						$.fancybox.hideLoading();
						$.fancybox({content: html});
				}, "html");
				//sendEvent($(this).data("event"), true);
				return false;
		});
		
		$('body').on('mouseenter', '.remove-basket-btn', function() {
				$(this).parents("tr").find("td").animate({backgroundColor: "rgba(252, 207, 204, 0.5)"}, 300)
		});
		
		$('body').on('mouseout', '.remove-basket-btn', function() {
				$(this).parents("tr").find("td").animate({backgroundColor: "transparent"}, 150);
		});		
		
		$('body').on('click', '.remove-basket-btn', function() {
				var url = $(this).attr('href');
				$(this).parents("tr").find("td").css({backgroundColor: "#fcc"})
				$(this).parents("tr").slideUp(300);
				$.post(url, "", function(data) {
						$(".mini-cart-holder").load("/ajax/basket.php");
				});
				return false;
		});

		
});

$(window).load(function () {
		$(".b_catalog").css("minHeight", ($(window).height() - $(".b_header").height() - $(".footer").height()) - 60 - 46);
		porject_resize();
		init_scroll();
		$('#share_this').click(function(){  sendEvent('share', 'soсialbutton'); });
});

$(window).resize(function () {
		$(".b_catalog").css("minHeight", ($(window).height() - $(".b_header").height() - $(".footer").height()) - 60 - 46);
		porject_resize();
		resize_scroll();
});

var sliderbar_project = false;
function resize_scroll() {
		if (sliderbar_project) {
				sliderbar_project.reinitialise();
		}
}
function init_scroll() {
		$("#sliderbar_project .wrap_item2").width($("#sliderbar_project .wrap_item3").width());
		if( $("#sliderbar_project").size()> 0)
				sliderbar_project = $("#sliderbar_project").jScrollPane().data('jsp');
}


//рассчет для ширины карточки товара
//отступы деленое на кол-во элементов, перебор наиболее удачного размера в цикле
function porject_set_clear() {
		$(".projects .item_block").each(function (i, e) {
				if ((i + 1) % 6 == 0 && i != 0)
						$(this).after("<div class='clear6 clear'></div>");
				if ((i + 1) % 5 == 0 && i != 0)
						$(this).after("<div class='clear5 clear'></div>");
				if ((i + 1) % 4 == 0 && i != 0)
						$(this).after("<div class='clear4 clear'></div>");
				if ((i + 1) % 3 == 0 && i != 0)
						$(this).after("<div class='clear3 clear'></div>");
				if ((i + 1) % 2 == 0 && i != 0)
						$(this).after("<div class='clear2 clear'></div>");
		});
}
function porject_resize() {
  
    var projects = $(".projects");
    projects.each(function(){
      var p = $(this);
  		var all = p.find(".item_block");
  		var max_width = 500;
  		var min_width = 277;
  		var min_margin = 22;
  		var block_width = p.find(".wrap_item").width() - 40;	
    	if(block_width<=0) return;
  		for (i = 6; i >= 2; i--) {
  				var w = Math.ceil((block_width - min_margin * (i - 1)) / i);
  				if (w <= max_width && w >= min_width) {
  						all.width(w+22);
  						p.find(".item").width(w);
  						p.find(".wrap_item2 > .clear:not(.clear" + (i) + ")").hide();
  						p.find(".wrap_item2 > .clear" + (i)).show();						
  						break;
  				}
  		}
  		
  		p.find(".wrap_item2 > .clear:last").show();						
  		
  		//Выравнивает картинку по центру внутри проекта
  		p.find(".item .img img").each(function(e,i){			
  				$(this).css({marginLeft: Math.floor( "-"+($(this).width() - w) / 2 )+"px" });
  				$(this).css({marginTop: Math.floor( "-"+($(this).height() - 204) / 2 )+"px" });
  		});				
  });																
}



function updateFavoriteBlock(data){
	var length = parseInt(data.COUNT);
	$(".favorite-head .b_count_text").html( ' ('+length+')' );	

  $(".projects_heart").each(function() {
    var id = $(this).data("rel").toString();
    if (data.ITEMS.indexOf(id) > -1) {            
      $(this).addClass('active');
      $(this).text('Убрать из избранного');
    } else {            
      $(this).removeClass('active');
      $(this).text('В избранное');
    }
  });

}

function showFavoriteMsg(data){
  if(!$('#comparison-msg').length) $('body').append('<div id="comparison-msg"><div class="b_wrapper"></div></div>');
  $('#comparison-msg .b_wrapper').html('');
  var cnthtml = declOfNum(data.COUNT, ["проект", "проекта", "проектов"] );
  //var compBtn = data.COUNT>1 ?'<a href="/favorite/" class="b-comp-msg-btn">Просмотреть</a>':'';
  var compBtn = '<a href="/favorite/" class="b-comp-msg-btn">Просмотреть</a>';
  var compTitle = '<div class="b-title"><div class="b-title-1">Проект <span>'+data.ADDED.PROPERTY_CODE_VALUE+'</span> добавлен в избранное</div><div class="b-title-2">Всего в избранном '+data.COUNT+' '+cnthtml+'</div></div>';
  var compImg = data.ADDED.IMG.src ? '<div class="b-img"><img src="'+data.ADDED.IMG.src+'" alt=""/></div>' : '';
  var compClose = '<div class="b-comp-msg-close" onclick="javascript:$(\'#comparison-msg\').fadeOut(); clearTimeout(compCloseTimeout);"></div>';
  var proj = compImg + compTitle + compBtn + compClose;
  if(compCloseTimeout) clearTimeout(compCloseTimeout);
  compCloseTimeout = setTimeout(function(){ $('#comparison-msg').fadeOut(); }, 5000);
  $('#comparison-msg .b_wrapper').html(proj);
  $('#comparison-msg').fadeIn();
}

function loadFavorite(){
		BX.ajax.loadJSON("/ajax/favorites.php", {}, function(data){ 
  		updateFavoriteBlock(data);
    });
}

function loadSimProjects(ID){
		BX.ajax.loadJSON("/ajax/simprojects.php", {ID : ID}, function(data){ 
  		RenderSimProjectsBlock(data);
    });
}

function RenderSimProjectsBlock(data){
	var length = parseInt(data.COUNT);
	//$(".favorite-head .b_count_text").html( ' ('+length+')' );	
	if(length){
    $("#b_sim_projects").html(data.HTML);
    loadComparison();
    $("#b_sim_projects .comparison").click(function(){
      return compareClickHandler($(this));
    });
    loadFavorite();
  	//Избранное
    $("#b_sim_projects .projects_heart").click(function() {
      return favoriteClickHandler($(this));
    });  	
  }
}

function declOfNum(number, titles){
    cases = [2, 0, 1, 1, 1, 2];
    return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
}


function intersect(a, b) {
    var t;
    if (b.length > a.length) t = b, b = a, a = t; // indexOf to loop over shorter
    return a.filter(function (e) {
        if (b.indexOf(e) !== -1) return true;
    });
}
