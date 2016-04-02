function recalc_filtr_box() {				
		//скрыть(показать) полосу прокрутки в большом фильтре
		if ($(".b_big_filtr .b_data_box").height() > $(".b_big_filtr").height()) {
				$(".b_big_filtr").css({overflowY: "scroll"});
		} else {
				$(".b_big_filtr").css({overflowY: "auto"});
		}
}

function recalcl_full_filtr() {

		//Расположить фильтры в 3-5 колонок
		var filtr_count = $(".b_big_filtr .b_box").size();
		var row_count = 5;
		if ($(window).width() <= 1560) {
				row_count = 4;
		}
		if ($(window).width() < 1280) {
				row_count = 3;
		}
		var row_item = Math.ceil(filtr_count / row_count);
		var row_html = "<div class='clear'>";
		var coll = 0;
		$(".b_big_filtr .b_box").each(function(i, e) {
				if (i % row_item == 0) {
						coll++;
						row_html += "</div><div class='b_block b_block_" + coll + "'>";
				}
				row_html += "<div class='" + $(this).attr("class") + "'>" + $(this).html() + "</div>";
		});
		row_html += "</div>";
		$(".b_big_filtr .b_full_filtr .r_filtr").html(row_html);
		$(".b_big_filtr .b_range_slide").html("");
}

function init_filtr(filtr_name, type) {
		/*
			* type - small = фильтр с права на странице
			* type - big = фильтр расширенный
			*/
		$(filtr_name + " .b_box .b_title").click(function() {
				$(this).parent().toggleClass("active").find(".b_hide").slideToggle(300)
		});
		$(filtr_name + " .b_checkbox").click(function() {

				if (type == "small") {
						var filtr_dop = $("#" + $(this).find(".in_box").data("rel") + "_FULL").parent(".b_checkbox");
				} else {
						var filtr_dop = $("#" + $(this).find(".in_box").data("rel")).parent(".b_checkbox");
						$("#" + $(this).find(".in_box").data("rel")).parents(".b_box").removeClass("b_hidden").addClass("active").find(".b_hide").show();
				}
				if ($(this).hasClass("noactive") && !$(this).hasClass("active"))
						return false;

				$(this).toggleClass("active");
				$(filtr_dop).toggleClass("active");

				if ($(this).hasClass("active")) {
						$(this).find("input.in_box").val("Y");
						$(filtr_dop).find("input.in_box").val("Y");
				} else {
						$(this).find("input.in_box").val("N");
						$(filtr_dop).find("input.in_box").val("N");
				}

				if (type == "small") {
						smartFilter.reload(BX($(this).find("input.in_box").attr("id")));
				} else {
						smartFilter.reload(BX($(this).find("input.in_box").attr("id")));
				}
				recalc_filtr_box();

		});

		$(filtr_name + " .b_range").each(function(i, e) {
				var min_v = $(this).find(".b_range_slide").data("min");
				var max_v = $(this).find(".b_range_slide").data("max");
				var min_s = $(this).find(".val_min").val();
				var max_s = $(this).find(".val_max").val();
				if (min_s == undefined || min_s == "" || parseInt(min_s) < min_v) {
						min_s = min_v;
				}
				$(this).find(".val_min").val(min_s);
				if (max_s == undefined || max_s == "" || parseInt(max_s) > max_v) {
						max_s = max_v;
				}
				$(this).find(".val_max").val(max_s);

				$(this).find(".val_min, .val_max").blur(function(event) {
						recalcRange(this, type);

				});
				$(this).find(".val_min, .val_max").keyup(function(event) {
//						var p = $(this).parents(".b_range");
//						var min = p.find(".val_min").val();
//						var max = p.find(".val_max").val();		
//						$(this).parents(".b_range").find(".b_range_slide").slider({values: [min, max]})
				});
				$(this).find(".val_min, .val_max").keydown(function(event) {
						if (event.keyCode == 13) {
								recalcRange(this, type);
								submitFiltr();
								return false;
						}
						return true;
				});
				$(this).find(".b_range_slide").slider({
						min: min_v, max: max_v,
						values: [min_s, max_s],
						range: true, animate: true,
						step: 	$(this).find(".b_range_slide").data("steep"),
						stop: function(event, ui) {

								if (type == "small") {
										var filtr_dop = $("#" + $(this).data("rel") + "_FULL");
								} else {
										var filtr_dop = $("#" + $(this).data("rel"));
										$("#" + $(this).data("rel")).parents(".b_box").removeClass("b_hidden").addClass("active").find(".b_hide").show();
								}

								$(this).parent().find(".val_min, .val_min_f").val(ui.values[0]);
								$(this).parent().find(".val_max, .val_max_f").val(ui.values[1]);

								$(filtr_dop).slider({values: ui.values});
								$(filtr_dop).parent().find(".val_min, .val_min_f").val(ui.values[0]);
								$(filtr_dop).parent().find(".val_max, .val_max_f").val(ui.values[1]);

								if (ui.values[0] == min_v) {
										$(this).parent().find(".val_min_f").val("");
										$(filtr_dop).parent().find(".val_min_f").val("");
								}
								if (ui.values[1] == max_v) {
										$(this).parent().find(".val_max_f").val("");
										$(filtr_dop).parent().find(".val_max_f").val("");
								}

								smartFilter.reload(BX($(this).attr("id")));
								recalc_filtr_box();
						},
						slide: function(event, ui) {
								$(this).parent().find(".val_min").val(ui.values[0]);
								$(this).parent().find(".val_max").val(ui.values[1]);
						}
				});
				$(this).find(".b_range_slide").find(".ui-slider-handle:last").addClass("last");
		});



		$(filtr_name + " .q").each(function() {
				if ($(this).data("text") != "") {
						$(this).tooltipster({
								content: "<div class='t_text'>" + $(this).data("text") + '</div><div class="t_close"></div>',
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
		$(filtr_name + " .q").click(function() {
				//$.tooltipster.hide();
				return false;
		});
}


$(window).resize(function() {
		recalcl_full_filtr();
		recalc_filtr_box();
		init_filtr(".b_big_filtr .r_filtr", "big");
});
$(document).ready(function() {

    /* more_filtr_sticker */
    var filtr_sticker = $('.more_filtr_sticker');
    if(!Cookies.get('more_filtr_sticker')){
      var filtr_sticker_leftpos = parseInt(filtr_sticker.css('left'));
      setInterval(function(){
        filtr_sticker.animate({'left':filtr_sticker_leftpos+20}, 500, 
        function(){ 
          filtr_sticker.animate({'left':filtr_sticker_leftpos}, 500);
        });
      }, 1000);
    } else {
      filtr_sticker.remove();
    }
    
		recalcl_full_filtr();
		recalc_filtr_box();
		init_filtr(".b_right_block .r_filtr", "small");
		init_filtr(".b_big_filtr .r_filtr", "big");

		$(".r_filtr .more_filtr").click(function() {
  		  filtr_sticker.remove();
  		  Cookies.set('more_filtr_sticker', 1);
				$(".bx_filter_popup_result").hide();
				$(".b_big_filtr").toggleClass("active");
				$("html").addClass("fx_content");
				$("body").animate({scrollTop: $(".b_header").height() + $(".b_header").offset().top}, 300);
				return false;
		});
		$(".b_big_filtr .b_close, .b_big_filtr .b_close_small").click(function() {
				$(".b_big_filtr").toggleClass("active");
				$("html").removeClass("fx_content");
				return false;
		});

		$("form.smartfilter").submit(function() {
				$("form.smartfilter input[type=hidden]").each(function() {
						if ($(this).val().length == 0 || $(this).val() == "N")
								$(this).removeAttr("name");
				});
				return true;
		});
		$(".b_big_filtr #set_filter").click(function() {
				submitFiltr();
				return false;
		});
		$(".b_search_id .b_input input").inputFuncion();
		$(".r_filtr .b_range .b_input input").focus(function() {
				$(this).parent().addClass("b_active2");
		});
		$(".r_filtr .b_range .b_input input").blur(function() {
				$(this).parent().removeClass("b_active2");
		});
		
		
		//Скрытие тегов
		$(".b_tags .show").click(function(){
				$(this).parent().find("a.hide").show();
				$(this).hide();
				return false;
		});
		$(".b_tags .hide_tags").click(function(){
				$(this).parent().find("a.hide").hide();
				$(".b_tags .show").show();
				return false;
		});		
});


function recalcRange(_this, type) {
		var p = $(_this).parents(".b_range");
		var min = p.find(".val_min").val();
		var max = p.find(".val_max").val();
		var reg = /[^\d\.,]/i //только цифры
		var reg2 = /[,]/i 
		min = min.replace(reg, "");
		min = min.replace(reg2, ".");		
		max = max.replace(reg, "");		
		max = max.replace(reg2, ".");				
		var min_v = p.find(".b_range_slide").data("min");
		var max_v = p.find(".b_range_slide").data("max");
		var min_s = p.find(".val_min").val();
		var max_s = p.find(".val_max").val();
		
		min = parseFloat(min);
		max = parseFloat(max);
		
		if (min > max && !$(_this).hasClass("val_min")) {
				min = max;				
		}
		if (max < min) {
				max = min;
		}
		
		if (min < min_v) {
				min = min_v;
		}
		if (max > max_v) {
				max = max_v;
		}
		if (max < min_v) {
				max = min_v;
		}		
		if (min > max_v) {
				min = max_v;
		}


		if (type == "small") {
				var filtr_dop = $("#" + p.find(".b_range_slide").data("rel") + "_FULL");
		} else {
				var filtr_dop = $("#" + p.find(".b_range_slide").data("rel"));
				$("#" + p.find(".b_range_slide").data("rel")).parents(".b_box").removeClass("b_hidden").addClass("active").find(".b_hide").show();
		}

		p.find(".b_range_slide").slider({values: [min, max]});
		$(filtr_dop).slider({values: [min, max]});

		p.find(".val_min, .val_min_f").val(min);
		p.find(".val_max, .val_max_f").val(max);
		$(filtr_dop).parent().find(".val_min, .val_min_f").val(min);
		$(filtr_dop).parent().find(".val_max, .val_max_f").val(max);

		if (min == min_v) {
				p.find(".val_min_f").val("");
				$(filtr_dop).parent().find(".val_min_f").val("");
		}
		if (min == max_v) {
				p.find(".val_max_f").val("");
				$(filtr_dop).parent().find(".val_max_f").val("");
		}
}

function submitFiltr() {
		$("form.smartfilter input[type=hidden]").each(function() {
				if ($(this).val().length == 0)
						$(this).removeAttr("name");
		});
		$("form.smartfilter #set_filter").attr("type", "hidden");
		$("form.smartfilter").submit();
}