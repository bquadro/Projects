/*
	* 
	* Временное сохранение заявки
	* 	
	*/

//Таймер что-бы не сработал скрипт оповещения раньше времени
var timer = false;

$(document).ready(function() {
		new_timer();
		$("body").on("blur", "input[type=text], textarea", function() {			
				setTimeout("order_save()", 100);
				new_timer();
		});
});

function order_save() {

		if ($("#ORDER_PROP_3").val() != "") {
				$("#ORDER_FORM").ajaxSubmit({
						url: "/ajax/order_save.php",
						complete: function(xhr) {
								console.log(xhr.responseText);
						}
				});

		}
}

function new_timer() {
		if (timer)
				clearInterval(timer);
		timer = setInterval("order_save()", 15000);
}

function showMessage(title){
		$.fancybox({content: "<h5 style='text-align: center;'>"+title+"</h5>"});
}