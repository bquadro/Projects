(function($) {
		$.fn.inputFuncion = function(params) {
				$(this).focus(function() {
						$(this).addClass("b_active");
						$(this).parent().addClass("b_active2");
				});
				$(this).blur(function() {
						if ($(this).val() == "") {
								$(this).removeClass("b_active");
								$(this).parent().removeClass("b_active2");
						}
				});
				$(this).each(function(i, e) {
						if ($(this).val() != "" ) {									
								$(this).addClass("b_active");
								$(this).parent().addClass("b_active2");
						}
				})
				return this;
		};
})(jQuery);