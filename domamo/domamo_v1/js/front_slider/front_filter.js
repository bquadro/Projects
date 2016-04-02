(function($) {
		$(document).ready(function() {
				$(".front_filter .block1 .b_title, .front_filter .block2 .b_title, .front_filter .block3 .b_title, .front_filter .block4 .b_title").click(function(){
						var bool = !$(this).parent().hasClass("active");
						$(".front_filter .block.active").find(".b_hide").hide(100);
						$(".front_filter .block.active").removeClass("active");
						if(bool){
								$(this).parent().find(".b_hide").slideToggle(200);
								$(this).parents(".block").toggleClass("active");								
						}
				});
				
				$(".front_filter .b_remove").click(function(){
						$(this).parent(".block").removeClass("change");
						$(this).parent(".block").removeClass("active");
						$(this).parent(".block").find(".b_hide").hide(100);
						var t = $(this).parent(".block").find(".b_title");
						t.html( t.data("name") );		
						$(this).parent(".block").find(".b_hide .b_check.active").removeClass("active")
						
						if($(this).parent(".block1").size() > 0){
								$(".block1 #f_square").slider({values: [80, 451]});
								$(".block1 .b_size").html(80 + "-" + 451);			
								$("#square_min").val("");								
								$("#square_max").val("");				
						}
						
						if($(this).parent(".block5").size() > 0){
								$(this).parent(".block5").find("#searchID").val("");								
								$(this).parent(".block5").find(".b_title").removeClass("active");
						}
						return false;
				});
				
				$(".front_filter .block input").blur(function() {
						if ($(this).val() != "") {
								$(this).parent().addClass("active");
						} else {
								$(this).parent().removeClass("active");
						}
				});
				//Скрыть блоки при клике вне области
				$("html").click(function(e) {
						var clicked = jQuery(e.target);
						if (clicked.parents(".front_filter .block").size() == 0) {
								$(".front_filter .block .b_hide").hide();
								$(".front_filter .block").removeClass("active");
						}
				});				
				
				//block 1, square
				$(".front_filter .block1 .b_ok").click(function(){
						var range = $("#f_square").slider( "option", "values");
						var t = $(".front_filter .block1 .b_title");
						if(range[0] != 80 || range[1]!=451) {
								$(t).html(range[0] + "-" + range[1] + "м&#178;");								
						}else{
								$(t).html( $(t).data("name") );
						}				
						$(".front_filter .block1 .b_hide").slideToggle(200);
						$(".front_filter .block").removeClass("active");
				});
				$(".front_filter .block1 .b_title").click(function(){											
						return false;
				});
				
				$("#f_square").next().html(80 + "-" + 451);
				$("#f_square").slider({
						min: 80, //parseInt($(".left_price2").html()),
						max: 451, //parseInt($(".right_price2").html()),
						values: [80,451],//[parseInt($(".left_price").html()), parseInt($(".right_price").html())],
						range: true,
						animate: true,
						stop: function(event, ui) {
								$(this).next().html(ui.values[0] + "-" + ui.values[1]);						
								$(".front_filter .block1 .b_title").html(ui.values[0] + "-" + ui.values[1] + "м&#178;");								
								$(".front_filter .block1").addClass("change");
								
								$("#square_min").val(ui.values[0]);								
								$("#square_max").val(ui.values[1]);				
						},
						slide: function(event, ui) {
								$(".front_filter .block1 .b_title").html(ui.values[0] + "-" + ui.values[1] + "м&#178;");								
								$(this).next().html(ui.values[0] + "-" + ui.values[1]);						
								$(".front_filter .block1").addClass("change");
						}
				});
				
			
				$(".front_filter .b_check ").click(function(){
						
						$(this).toggleClass("active");			
						//console.log($("#".$(this).data("check")).size());
						if($(this).parents(".block").hasClass("block2")){
								$("#"+$(this).data("check")).val( $(this).hasClass("active")?"Y":"N" );
						}else if($(this).parents(".block").hasClass("block3")){
								var min_room = 0;
								var max_room = 0;
								var b = $(this).parents(".block");
								b.find(".b_check.active").each(function(){
										var i = parseInt($(this).data("check"));
										if(i<min_room || min_room == 0)
												min_room = i;
										if(i>max_room || max_room == 0)
												max_room = i;
								});
								if(max_room>=6){
										max_room = 0;
								}
								$("#room_min").val(min_room>0?min_room:"");
								$("#room_max").val(max_room>0?max_room:"");
								
						}else if($(this).parents(".block").hasClass("block4")){					
	
										var b = $(this).parents(".block");
										var m =  b.find(".b_check.active#_m").size()>0;
										var f = b.find(".b_check.active#_f1, .b_check.active#_f2, .b_check.active#_f3").size()>0;
										$("#f1").val( b.find(".b_check.active#_f1").size()>0 ?"Y":"N");
										$("#f1_m").val( ( b.find(".b_check.active#_f2").size()>0 && !m ) || (!f && m) ?"Y":"N");
										$("#f2").val( b.find(".b_check.active#_f2").size()>0?"Y":"N");		
										$("#f2_m").val( ( b.find(".b_check.active#_f3").size()>0  && !m ) || ( b.find(".b_check.active#_f2").size()>0 && m ) || (!f && m) ?"Y":"N");
										$("#f3").val( b.find(".b_check.active#_f3").size()>0?"Y":"N");		
										$("#f3_m").val(  ( b.find(".b_check.active#_f3").size()>0 && m ) || (!f && m)?"Y":"N");
										
										$(".under").val( b.find(".b_check.active#_u").size()>0?"Y":"N");		
										$(".car").val( b.find(".b_check.active#_c").size()>0?"Y":"N");		
						}
						
						var block = $(this).parents(".block");
						var res = "";
						block.find(".b_check.active").each(function(){
								if(res != "")
										res += ", ";
								res += $(this).find(".n").text();
						});
						
						if(block.find(".b_title").data("desc") != undefined && block.find(".b_check.active").size() >= 2){
								block.find(".b_title").html(block.find(".b_check.active").size() + " " +block.find(".b_title").data("desc"));
								block.addClass("change");
						}else if(res != ""){
								block.find(".b_title").html(res);
								block.addClass("change");
						}else{
								block.find(".b_title").html(block.find(".b_title").data("name"));
								block.removeClass("change");
						}
				});
				

										
										
										
		});

})(jQuery);