function isNumber(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}

function JCSmartFilter(ajaxURL, viewMode) {
		this.ajaxURL = ajaxURL;
		this.form = null;
		this.timer = null;
		this.viewMode = viewMode;
		this.followValues = [];
		this.followFilterType = false;
}

JCSmartFilter.prototype.keyup = function (input) {
		if (!!this.timer) {
				clearTimeout(this.timer);
		}
		this.timer = setTimeout(BX.delegate(function () {
				this.reload(input);
				recalc_filtr_box();
		}, this), 100);
};

JCSmartFilter.prototype.click = function (checkbox) {
		if (!!this.timer) {
				clearTimeout(this.timer);
		}		
		this.reload(checkbox);		
};

JCSmartFilter.prototype.reload = function (input) {
		var values = [];

		this.position = BX.pos(input, true);
		this.form = BX("rightFilter");
		if (this.form) {
				values[0] = {name: 'ajax', value: 'y'};
				this.gatherInputsValues(values, BX.findChildren(this.form, {'tag': new RegExp('^(input|select)$', 'i')}, true));			
				var vv = [];	
				this.gatherInputsValues(vv, BX.findChildren(input.parentNode, {'tag': new RegExp('^(input|select)$', 'i')}, true));				
				this.curFilterinput = input;			
				
				//console.log($(input).attr('data-rel'));
				//console.log($(input).parents('.b_full_filtr').length);
				
				this.followFilterType = $(input).parents('.b_full_filtr').length === 1;
        this.followValues = this.valuesFilter(values);

				BX.ajax.loadJSON( this.ajaxURL, this.values2post(values), BX.delegate(this.postHandler, this) );
		}
};

JCSmartFilter.prototype.postHandler = function (result) {
		var PID, arItem, i, ar, control, hrefFILTER, url, curProp, trackBar;
		var modef = BX('modef');
		var modef_num = BX('modef_num');
		var modef_text = BX('modef_text');
		var modef_close = BX('modef_close');


		if (!!result && !!result.ITEMS) {
				for (PID in result.ITEMS) {
						if (result.ITEMS.hasOwnProperty(PID)) {
								arItem = result.ITEMS[PID];
								
								//Если От-До								
								if (arItem.PROPERTY_TYPE === 'N' || arItem.PRICE) {

										var control = $('#'+arItem.VALUES.MAX.CONTROL_NAME);														
										var control_full = $('#'+arItem.VALUES.MAX.CONTROL_NAME+"_FULL");
            				
            				var slider = control.parents('.kombox-num').find('.kombox-range div');
            				slider.data('range-from', parseFloat(arItem.VALUES.MIN.FILTERED_VALUE));
            				slider.data('range-to', parseFloat(arItem.VALUES.MAX.FILTERED_VALUE));
            				slider.ionRangeSlider("updateRange");

            				var slider = control_full.parents('.kombox-num').find('.kombox-range div');
            				slider.data('range-from', parseFloat(arItem.VALUES.MIN.FILTERED_VALUE));
            				slider.data('range-to', parseFloat(arItem.VALUES.MAX.FILTERED_VALUE));
            				slider.ionRangeSlider("updateRange");
            				
										//console.log(arItem["VALUES"]["MAX"]["FILTERED_VALUE"] == arItem["VALUES"]["MIN"]["FILTERED_VALUE"]);
										/*
										if(arItem["CODE"] == "RETAIL" ){
												
												var filtr_main = $("#range_arrFiltrCatalogMain_" + arItem["ID"]+"" );
												var filtr_dop = $("#range_arrFiltrCatalogMain_" + arItem["ID"]+"_FULL"  );										
												console.log(arItem["VALUES"]);
												if(arItem["VALUES"]["MAX"]["FILTERED_VALUE"] == arItem["VALUES"]["MIN"]["FILTERED_VALUE"]){
														
														//console.log("dis");
												}else if(arItem["VALUES"]["MAX"]["HTML_VALUE"] == "" && arItem["VALUES"]["MIN"]["HTML_VALUE"] == ""){
														
														filtr_main.slider( { values: [ arItem["VALUES"]["MIN"]["FILTERED_VALUE"],  arItem["VALUES"]["MAX"]["FILTERED_VALUE"] ] });
														filtr_main.slider( { max: parseInt(arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) });
														
														filtr_main.slider( { min: parseInt(arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) });
														//min: arItem["VALUES"]["MIN"]["FILTERED_VALUE"]
												}

										}
										*/
												
												
//										trackBar = window['trackBar' + PID];
//										if (!trackBar && arItem.ENCODED_ID)
//												trackBar = window['trackBar' + arItem.ENCODED_ID];
//
//										if (trackBar && arItem.VALUES) {
//												if (arItem.VALUES.MIN && arItem.VALUES.MIN.FILTERED_VALUE) {
//														trackBar.setMinFilteredValue(arItem.VALUES.MIN.FILTERED_VALUE);
//												}
//												if (arItem.VALUES.MAX && arItem.VALUES.MAX.FILTERED_VALUE) {
//														trackBar.setMaxFilteredValue(arItem.VALUES.MAX.FILTERED_VALUE);
//												}
//										}
										
								} else if (arItem.VALUES) {
										
										//чекбоксы
										for (i in arItem.VALUES) {
												if (arItem.VALUES.hasOwnProperty(i)) {
														ar = arItem.VALUES[i];
														control = BX(ar.CONTROL_ID);														
														control_full = BX(ar.CONTROL_ID+"_FULL");
														if (!!control) {
																var label = document.querySelector('[data-role="label_' + ar.CONTROL_ID + '"]');
																var label_full = document.querySelector('.b_big_filtr [data-role="label_' + ar.CONTROL_ID + '"]');
																
																if (ar.DISABLED){
																		if (label){
																				BX.addClass(label, 'noactive');
																				BX.addClass(label_full, 'noactive');																				
																		}else{
																				BX.addClass(control.parentNode, 'noactive');
																				BX.addClass(control_full.parentNode, 'noactive');
																		}
																} else {
																		if (label){
																				BX.removeClass(label, 'noactive');
																				BX.removeClass(label_full, 'noactive');																				
																		}else{
																				BX.removeClass(control.parentNode, 'noactive');
																				BX.removeClass(control_full.parentNode, 'noactive');
																		}
																}
														}
												}
										}
										
								}
						}
				}

				if (!!modef && !!modef_num)
				{
						modef_num.innerHTML = result.ELEMENT_COUNT;
						modef_text.innerHTML = conjugation_words(result.ELEMENT_COUNT, "Проект", "Проекта", "Проектов");
						hrefFILTER = BX.findChildren(modef, {tag: 'A'}, true);
						if (result.FILTER_URL && hrefFILTER) {
								hrefFILTER[0].href = BX.util.htmlspecialcharsback(result.FILTER_URL);
						}

						if (result.FILTER_AJAX_URL && result.COMPONENT_CONTAINER_ID)
						{
								BX.bind(hrefFILTER[0], 'click', function (e)
								{
										var url = BX.util.htmlspecialcharsback(result.FILTER_AJAX_URL);
										BX.ajax.insertToNode(url, result.COMPONENT_CONTAINER_ID);
										return BX.PreventDefault(e);
								});
						}

						if (result.INSTANT_RELOAD && result.COMPONENT_CONTAINER_ID)
						{
								url = BX.util.htmlspecialcharsback(result.FILTER_AJAX_URL);
								BX.ajax.insertToNode(url, result.COMPONENT_CONTAINER_ID);
						}
						else
						{
								if (modef.style.display === 'none')
								{
										modef.style.display = 'inline-block';
										
										BX.bind(BX.findChild(modef, {'class' : 'modef_close'}), 'click', function (e)
    								{
    										modef.style.display = 'none';
    										return BX.PreventDefault(e);
    								});
								}
								if (this.viewMode == "vertical")
								{

										curProp = BX.findChild(BX.findParent(this.curFilterinput, {'class': 'bx_filter_parameters_box'}), {'class': 'bx_filter_container_modef'}, true, false);
										
										curProp.appendChild(modef);
								}
						}
				}
		}
};

JCSmartFilter.prototype.gatherInputsValues = function (values, elements)
{
		if (elements)
		{
				for (var i = 0; i < elements.length; i++)
				{
						var el = elements[i];
						if (el.disabled || !el.type)
								continue;

						switch (el.type.toLowerCase())
						{
								case 'text':
								case 'textarea':
								case 'password':
								case 'hidden':
								case 'select-one':										
										if (el.value.length)
												values[values.length] = {name: el.name, value: el.value};
										break;
								case 'radio':
								case 'checkbox':
										if (el.checked)
												values[values.length] = {name: el.name, value: el.value};
										break;
								case 'select-multiple':
										for (var j = 0; j < el.options.length; j++)
										{
												if (el.options[j].selected)
														values[values.length] = {name: el.name, value: el.options[j].value};
										}
										break;
								default:
										break;
						}
				}
		}
};

JCSmartFilter.prototype.values2post = function (values)
{
		var post = new Array;
		var current = post;
		var i = 0;
		while (i < values.length)
		{
				var p = values[i].name.indexOf('[');
				if (p == -1)
				{
						current[values[i].name] = values[i].value;
						current = post;
						i++;
				}
				else
				{
						var name = values[i].name.substring(0, p);
						var rest = values[i].name.substring(p + 1);
						if (!current[name])
								current[name] = new Array;

						var pp = rest.indexOf(']');
						if (pp == -1)
						{
								//Error - not balanced brackets
								current = post;
								i++;
						}
						else if (pp == 0)
						{
								//No index specified - so take the next integer
								current = current[name];
								values[i].name = '' + current.length;
						}
						else
						{
								//Now index name becomes and name and we go deeper into the array
								current = current[name];
								values[i].name = rest.substring(0, pp) + rest.substring(pp + 1);
						}
				}
		}
		return post;
};

JCSmartFilter.prototype.valuesFilter = function (values)
{
		var post = [];
		for (i=0; i < values.length; i++)
		{
				var name = values[i].name;
				var value = values[i].value;
        if(name != '' && name != 'ajax' && value != 'N'){
          post.push(values[i]);
        }
		}
		return post;
}

function conjugation_words(col_max, word1, word2, word3) {
		col_max = Math.abs(col_max) % 100; //переборка букв алфавита
		col_min = col_max % 10; // установка определенных значений
		if (col_max > 10 && col_max < 20)
				return word3;
		if (col_min > 1 && col_min < 5)
				return word2;
		if (col_min == 1)
				return word1;
		return word3;
}
