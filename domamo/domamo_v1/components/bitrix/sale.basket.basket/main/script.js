$(document).ready(function () {
		$(".ordering_table_row .q").each(function () {
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
		$(".ordering_table_row .q").click(function () {
				return false;
		});


		$(".order_block_button, .order_block_label_title").click(function () {
				$(this).parents('.order_block').toggleClass('order_block-open');
				$(this).toggleClass('order_block_button-open');
				return false;
		});
		$(".ordering_table_row").click(function () {
				$(this).toggleClass('ordering_table_row-checked');
				if ($(this).hasClass('ordering_table_row-checked')) {
						$(this).find(".checkbox").val("Y");
				} else {
						$(this).find(".checkbox").val("N");
				}
				changeOrder();
				return false;
		});

});

function checkOut() {
		BX("basket_form").submit();
		return true;
}

var order_load = false;
var order_reload = false;
var result ;
function changeOrder() {
		$.fancybox.showLoading()
		$("form#basket_form").ajaxSubmit({
				url: "/local/ajax/reload_basket.php",
				complete: function (xhr) {
						result = JSON.parse(xhr.responseText);

						for (i = 0; i < result.items.length; i++) {
								var item = result.items[i];
								$("#price_options_"+item.product_id).html(item.total_price);
						}
						$("#allSum_FORMATED").html(result.total_price);

						$.fancybox.hideLoading();
				}
		});
		return false;
}