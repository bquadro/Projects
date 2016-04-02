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
				//$.tooltipster.hide();
				return false;
		});
})

function checkOut() {
		BX("basket_form").submit();
		return true;
}