BX.namespace("BX.Iblock.Catalog");

BX.Iblock.Catalog.CompareClass = (function()
{
	var CompareClass = function(wrapObjId)
	{
		this.wrapObjId = wrapObjId;
	};

	CompareClass.prototype.MakeAjaxAction = function(url)
	{
		BX.showWait(BX(this.wrapObjId));
		BX.ajax.post(
			url,
			{
				ajax_action: 'Y'
			},
			BX.proxy(function(result)
			{
				BX.closeWait();
				BX(this.wrapObjId).innerHTML = result;
				loadComparison();
			}, this)
		);
	};

	return CompareClass;
})();

var compCloseTimeout = false;

function showComparisonMsg(data){
  if(!$('#comparison-msg').length) $('body').append('<div id="comparison-msg"><div class="b_wrapper"></div></div>');
  $('#comparison-msg .b_wrapper').html('');
  var cnthtml = compareDeclOfNum(data.COUNT, ["проект", "проекта", "проектов"] );
  var compBtn = data.COUNT>1 ?'<a href="/catalog/comparison/" class="b-comp-msg-btn">Сравнить</a>':'';
  var compTitle = '<div class="b-title"><div class="b-title-1">Проект <span>'+data.ADDED.PROPERTY_CODE_VALUE+'</span> добавлен к сравнению</div><div class="b-title-2">Всего в сравнении '+data.COUNT+' '+cnthtml+'</div></div>';
  var compImg = data.ADDED.IMG.src ? '<div class="b-img"><img src="'+data.ADDED.IMG.src+'" alt=""/></div>' : '';
  var compClose = '<div class="b-comp-msg-close" onclick="javascript:$(\'#comparison-msg\').fadeOut(); clearTimeout(compCloseTimeout);"></div>';
  var proj = compImg + compTitle + compBtn + compClose;
  if(compCloseTimeout) clearTimeout(compCloseTimeout);
  compCloseTimeout = setTimeout(function(){ $('#comparison-msg').fadeOut(); }, 5000);
  $('#comparison-msg .b_wrapper').html(proj);
  $('#comparison-msg').fadeIn();
}

function hideComparisonMsg(data){
  $('#comparison-msg').fadeOut();

}

function loadComparison(){
		BX.ajax.loadJSON("/catalog/comparison/", {'event': 'LOAD_COMPARE_LIST', 'ajax_json': 'Y'}, function(data){ 
  		updateComparisonBlock(data); 
    });
}

function updateComparisonBlock(data){
	var length = parseInt(data.COUNT);
	if( !isNaN(length) && length > 0){
		$(".compare-head").addClass("active");
		$(".compare-nav").addClass("active");				
	} else {
		$(".compare-head").removeClass("active");		
		$(".compare-nav").removeClass("active");					
	}
	$(".compare-nav .b_count_html").html( length + ' ' + compareDeclOfNum(length, ["проект", "проекта", "проектов"] ) );
	$(".compare-head .b_count").html( length );
	$(".compare-head .b_count_text").html( compareDeclOfNum(length, ["проект", "проекта", "проектов"] ) );	

  $(".comparison").each(function() {
    var id = $(this).data("rel").toString();
    if (data.ITEMS.indexOf(id) > -1) {            
      $(this).addClass('active');
      $(this).text('Убрать из сравнения');
    } else {            
      $(this).removeClass('active');
      $(this).text('Сравнить проект');
    }
  });

}
	
function bx_catalog_compare_block(){
	//Подсказка
	$('#bx_catalog_compare_block .q').each(function(){
		if($(this).data("text") != ""){
			$(this).tooltipster({
				content: "<div class='t_text'>" + $(this).data("text")+'</div><div class="t_close"></div>',
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
}

function bx_compare_fixed(){
	//Подсказка
	$('.compare-fixed .q').each(function(){
		if($(this).data("text") != ""){
			$(this).tooltipster({
				content: "<div class='t_text'>" + $(this).data("text")+'</div><div class="t_close"></div>',
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
}

function bComparisonEvents(){
  var scrollContainer = null;
  if($.fn.scroller){
    $('.bx_compare_page .table_compare').scroller({
        horizontal: true,
        handleSize: 180
    });
    $(window).resize( function(){ $('.bx_compare_page .table_compare').scroller("reset"); } );
    scrollContainer = $('.bx_compare_page .table_compare .scroller-content');
  } else {
    scrollContainer = $('.bx_compare_page .table_compare');
  }
  
  scrollContainer.scroll(function(){
    var t = $(this).find('.data-table');
    var l = t.position().left;
      if(l < 0){
        bComparisonScrollStart();
      } else {
        bComparisonScrollStop();
      }
  });
}

function bComparisonScrollStop(){
  $('.bx_compare_page .table_compare').removeClass('scrolled');
  $('.compare-fixed').remove();
  
}

function bComparisonScrollStart(){
  if(!$('.bx_compare_page .table_compare').hasClass('scrolled')){
    $('.bx_compare_page .table_compare').addClass('scrolled');
    var fixtable = $('<table class="data-table"></table>');
    $('.bx_compare_page .table_compare .data-table tr').each(function(){
      var tRow = $(this);
      var classes = tRow.attr('class') ? tRow.attr('class') : '';
      var dRow = $('<tr class="'+classes+'"></tr>');
      tRow.find('td.first').each(function(){
        var tdHeight = parseInt($(this).height());
       dRow.append('<td class="'+$(this).attr('class')+'" style="height:'+tdHeight+'px">'+$(this).html()+'</td>');
      });
      fixtable.append(dRow);
    });
    $('.bx_compare').append('<div class="compare-fixed"><div class="table_compare"></div></div>');
    $('.compare-fixed .table_compare').append(fixtable);
    bx_compare_fixed();
  }
}

$(document).ready(function () {
  
		//Загрузка сравнения
    loadComparison();
   
		//События добавления к сравнению и удаления из сравнения

    $(".comparison").click(function(){
      return compareClickHandler($(this));
    }); 
		
    bComparisonEvents();
    
		BX.addCustomEvent('onAjaxSuccess', function(){
  		bx_catalog_compare_block();
      bComparisonEvents();
  	}); 
});


function compareClickHandler(obj){
	  obj.toggleClass("active");
	  var id = obj.data("rel");
    if (obj.hasClass("active")){   
      var query = {'event': 'ADD_TO_COMPARE_LIST', 'ID': id , 'ajax_json' : 'Y'}; 
    } else {
      var query = {'event': 'DELETE_FROM_COMPARE_LIST', 'ID': id , 'ajax_json' : 'Y'};
    }
    BX.ajax.loadJSON("/catalog/comparison/", 
    query, 
    function(data){ 
      updateComparisonBlock(data);
      showComparisonMsg(data); 
    });
    return false;
}
    
function compareDeclOfNum(number, titles){
    cases = [2, 0, 1, 1, 1, 2];
    return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
}

function compareIntersect(a, b) {
    var t;
    if (b.length > a.length) t = b, b = a, a = t; // indexOf to loop over shorter
    return a.filter(function (e) {
        if (b.indexOf(e) !== -1) return true;
    });
}
