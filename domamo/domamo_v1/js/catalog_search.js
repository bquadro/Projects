$(document).ready(function() {
		

		$(".b_search_id .s_btn").click(function(){
				var resBlock = $(this).parents(".b_search_id").find(".b_search_result");
				var active = resBlock.find("a.active");
				if (active.size() > 0){
						window.location.href = active.attr("href");										
				}else if( resBlock.find("a:first").size()>0){
						window.location.href = resBlock.find("a:first").attr("href");
				}
				return false;				
		})
		$("#searchID").keyup(function(event) {
				if (event.keyCode === 40 || event.keyCode === 38) {
						return false;
				}
				var query = $(this).val();
				if (query.length >= 2) {
						$.post("/ajax/search_id.php", {q: query}, function(html) {
								if(html != "")
										$("#searchID").parents(".b_search_id").find(".b_search_result").html(html).show();
								else
										$("#searchID").parents(".b_search_id").find(".b_search_result").html("").hide();
						}, "html");
				}else{
						$("#searchID").parents(".b_search_id").find(".b_search_result").html("").hide();
				}
		});
		
		$("#searchID").keydown(function(event) {
				var resBlock = $("#searchID").parents(".b_search_id").find(".b_search_result");
				switch (event.keyCode) {
						case 40:
								var active = resBlock.find("a.active");
								if (active.size() > 0 && active.next("a").size() > 0) {
										active.removeClass("active");
										active.next().addClass("active");
								} else {
										active.removeClass("active");
										resBlock.find("a:first").addClass("active");
								}
								return false;
						case 38:
								var active = resBlock.find("a.active");
								if (active.size() > 0 && active.prev("a").size() > 0) {
										active.removeClass("active");
										active.prev().addClass("active");
								} else if (active.size() > 0) {
										active.removeClass("active");
										resBlock.find("a:last").addClass("active");										
								}	else {
										active.removeClass("active");
										resBlock.find("a:first").addClass("active");
								}
								return false;
						case 13:
								var active = resBlock.find("a.active");
								if (active.size() > 0){
										window.location.href = active.attr("href");										
								}else if( resBlock.find("a:first").size()>0){
										window.location.href = resBlock.find("a:first").attr("href");
								}
								return false;
				}

		});

});

