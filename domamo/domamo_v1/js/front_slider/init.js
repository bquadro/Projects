	var cSpeed=5;
	var cWidth=128;
	var cHeight=128;
	var cTotalFrames=20;
	var cFrameWidth=128;
	var cImageSrc='images/sprites.gif';
	
	var cImageTimeout=false;
	var cIndex=0;
	var cXpos=0;
	var cPreloaderTimeout=false;
	var SECONDS_BETWEEN_FRAMES=0;
	
	function startAnimation(){		
		//FPS = Math.round(100/(maxSpeed+2-speed));
		FPS = Math.round(100/cSpeed);
		SECONDS_BETWEEN_FRAMES = 1 / FPS;		
		cPreloaderTimeout=setTimeout('continueAnimation()', SECONDS_BETWEEN_FRAMES/1000);		
	}
	
	function continueAnimation(){
		cXpos += cFrameWidth;
		cIndex += 1;
		if (cIndex >= cTotalFrames) {
			cXpos =0;
			cIndex=0;
		}		
		if(document.getElementById('loaderImage'))
				document.getElementById('loaderImage').style.backgroundPosition=(-cXpos)+'px 0';		
		cPreloaderTimeout=setTimeout('continueAnimation()', SECONDS_BETWEEN_FRAMES*1000);
	}
	
	function stopAnimation() {
		clearTimeout(cPreloaderTimeout);
		cPreloaderTimeout=false;
		$("#loaderImage").attr("style", "display: none;");
	}
	
	function imageLoader(s, fun) {
		clearTimeout(cImageTimeout);
		cImageTimeout=0;
		genImage = new Image();
		genImage.onload=function (){
				cImageTimeout=setTimeout(fun, 0)
		};
		genImage.onerror=new Function('alert(\'Could not load the image\')');
		genImage.src=s;
	}
	
startAnimation();
//startAnimation();
$(document).ready(function() {

		var load_img = $(".main_slider ul li .b_image img:first").data("src");
		$(".main_slider ul li .b_image img:first").data("src", "");
		imageLoader(load_img, function() {
				var _img = $(".main_slider ul li .b_image img:first");
				_img.attr("src", load_img);
				$(".main_slider ul li .b_image img").each(function() {
						if ($(this).data("src") != "")
								$(this).attr("src", $(this).data("src"));
				});
				stopAnimation();
				$(".bxslider.cycle-slideshow").cycle();
				$(".main_slider ul li .b_image img").animate({opacity: 1}, 600);
				$(".front_filter").delay(700).animate({opacity: 1}, 800);
				//$(".front_filter .slogan").delay(1200).animate({opacity: 1, top: -75}, 400);
				$(".front_filter .slogan").delay(1200).animate({opacity: 1, top: -75}, 500);
				$(".front_filter .block, .front_filter .plus, .front_filter > input").delay(1300).animate({opacity: 1}, 400);

				//Old element navigation
				$(".main_slider .pager, .main_slider .text, .main_slider .arrow_right, .main_slider .arrow_left").delay(2700).animate({opacity: 1}, 400);

		});

});



$(document).ready(function () {
		change_slider();
});
$(window).load(function () {
		change_slider();
});
$(window).resize(function () {
		change_slider();
});


//Изменение размера слайдера для главной
//по выстое и ширине
function change_slider() {
		//var slider_height = $(window).height() - (59 + 54 + 60);
		var slider_height = $(window).height() - ($(".b_header").height() + 40);
		
		var slider_width = $(".main_slider ul").width();

		if (slider_height < 500) {
				slider_height = 500;
		} else if (slider_height > 1100) {
				slider_height = 1100;
		}		
		$(".main_slider ul").height(slider_height);

		$(".main_slider .b_image img").each(function () {
				var img_h = $(this).data("height");			
				var img_w = $(this).data("width");
				//alert(img_h +" "+ img_w);
				$(this).css({
						marginLeft:  ((slider_width - img_w) / 2 ) + "px",
						marginTop:  ((slider_height - img_h) / 2 ) + "px"
				});				
				//Расчет размера изображения с шагом в 5%
				for (var i = 4; i <= 20; i++) {
						//console.log( img_h * i * 0.1 );
						if (img_w * i * 0.05 > slider_width && img_h * i * 0.05 > slider_height) {
								var new_w = Math.ceil(img_w * i * 0.05);
								var new_h = Math.ceil(img_h * i * 0.05);
								
								$(this).css({
										height: new_h + "px",
										width: new_w + "px",
										marginLeft:  ((slider_width - new_w) / 2 ) + "px",
										marginTop:  ((slider_height - new_h) / 2 ) + "px"
								});
								break;
						}
				}
	
		});
}