$(document).ready(function() {
		//Планы, фасады и т.п.
		$("a.fancybox_ajax").fancybox({
			type: 'ajax',
			padding: 0,
			margin: 35,
			ajax  : {
				dataType : 'html',
				headers  : { 'X-fancyBox': true }
			}
		});
		
		$(".price_select").click(function() {
				$(this).find(".b_hide").slideToggle(200);
				return false;
		});		
		$(".b_project .b_tab a").click(function(){
				if( !$(this).hasClass("active") ){
						$(".b_project .b_tab a.active, .b_all_tab > div.active" ).removeClass("active");
						$( this ).addClass("active");
						$( $(this).attr("href") ).addClass("active");
						porject_resize();
				}
				return false;
		});
});

function fotorama_resize(){
		if($(".fotorama").size()>0){
				var fotorama_height = ( $(document).width() > 1080 ) ? 550:400;				
				var fotorama = $(".fotorama").data("fotorama");				
				if(fotorama.options.height != fotorama_height){
						$(".fotorama").data("fotorama").resize({  height: fotorama_height});		
				}
		};		
};

$(window).resize(function(){
		//fotorama_resize();
});

$(window).load(function(){
		//fotorama_resize();
});
