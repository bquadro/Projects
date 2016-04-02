function loadWatchList(){
	/*
  	//OLD
	if(window.location.pathname == '/watch-history/') return;
	var productID = $('.b_project').length ? parseInt($('.b_project').attr('data-product-id')) : 0;
	BX.ajax.post("/ajax/watchlist.php", { productID: productID }, function(html){ 
		$('.footer .b_wrapper').prepend(html);
  });
  */
  
	if(window.location.pathname == '/catalog/watchlist/') return;
	var productID = $('.b_project').length ? parseInt($('.b_project').attr('data-product-id')) : 0;
	BX.ajax.post("/catalog/watchlist/", {'event': 'ADD_TO_WATCH_LIST', 'ID': productID , 'ajax_action' : 'Y' , 'shortList' : 'Y'}, function(html){ 
		$('.footer .b_wrapper').prepend(html);
  });
}

$(document).ready(function () {
  loadWatchList();
});