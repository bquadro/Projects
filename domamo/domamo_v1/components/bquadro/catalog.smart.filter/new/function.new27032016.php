<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
		die();

if(!function_exists('b_filter_item_render')){
  function b_filter_item_render($key, $arItem, $show_all, $arResult, $arParams, $itemGroup=null, $key_group=null){ 
				

				//Меняем отображение если кол-во вариантов 1
				if( $arItem["CODE"] == 'RETAIL' ){
						$arItem["DISPLAY_TYPE"] = "A";
						$arItem["UNITS"] = "&#8381;";
						}
				if( count($arItem["VALUES"]) == 1 )
						$arItem["DISPLAY_TYPE"] = "C1";
				
				
				$class = "b_box bx_filter_parameters_box";
				//Скрыть
				if($arItem["SHOW_MAIN"] == "Y" && !$show_all && $arItem["DISPLAY_EXPANDED"] != "Y"){						
						
						/*?><input type="hidden" name="<?= $arItem["CONTROL_NAME"]?>" id="<?= $arItem["CONTROL_ID"]?>" value="<?= $arItem["HTML_VALUE"]?>" /><?*/
						//continue;
						$class .= " b_hidden";
				}	

				switch ($arItem["DISPLAY_TYPE"]){
						case "A":	 //От-До								
								
								#$arItem["VALUES"]["MIN"]["VALUE"] = floor($arItem["VALUES"]["MIN"]["VALUE"]);
								#$arItem["VALUES"]["MAX"]["VALUE"] = ceil($arItem["VALUES"]["MAX"]["VALUE"]);
								$steep = "1";
								
								switch	($arItem["CODE"]){
										case "HEIGHT1FL":
										case "HEIGHT2FL":
										case "HEIGHT3FL":
										case "HEIGHTPH":
										case "HEIGHTGF":
												$steep = "0.01";
												break;
								}
								
								?>
								<div class="<?=$class?> " data-active="<?=$arItem["DISPLAY_EXPANDED"]== "Y";?>" data-group="<?=$arItem["GROUP_ID"]?>" data-prop-id="<?=$arItem["ID"]?>">
										<div class="b_title">
												<div class="b_title_left"><?=$arItem["NAME"]?></div>
												<?if($arItem["DESCRIPTION"]):?><div class="q" data-text="<?=$arItem["DESCRIPTION"]?>" ></div><?endif;?>
												<div class="b"></div>														
										</div>
										<div class="clear"></div>
										<div class="b_range" >
												<div class="b_l1">
                            <ul class="kombox-num">
                            	<li>
                            		<div class="b_input"><input 
                            			class="kombox-input kombox-num-from val_min" 
                            			type="text" 
                            			name="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>" 
                            			id="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?><?=$show_all?"_FULL":""?>" 
                            			value="<?= $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>" 
                            		/></div>
                            		<div class="b_sep"> - </div>
                            		<div class="b_input"><input 
                            			class="kombox-input kombox-num-to val_max"
                            			type="text" 
                            			name="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>" 
                            			id="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?><?=$show_all?"_FULL":""?>" 
                            			value="<?= $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>" 
                            		/></div>
                            		<?	
  													if(isset($arItem["UNITS"]) && $arItem["UNITS"]){
    													echo '<div class="b_label b_label_rub">'.$arItem["UNITS"].'</div>';
    												} else {
  														switch	($arItem["CODE"]){
  																case "PRICE_FULL":
  																		echo '<div class="b_label b_label_rub">&#8381;</div>';
  																		break;
  																case "AREA1":
  																		echo '<div class="b_label b_label_rub">м&#178;</div>';
  																		break;
  														}
  													}	

$min = isset($arItem["VALUES"]["MIN"]["HTML_VALUE"]) && $arItem["VALUES"]["MIN"]["HTML_VALUE"] != '' 
  ? 
$arItem["VALUES"]["MIN"]["HTML_VALUE"]
  : 
$arItem["VALUES"]["MIN"]["VALUE"];

$max = isset($arItem["VALUES"]["MAX"]["HTML_VALUE"]) && $arItem["VALUES"]["MIN"]["HTML_VALUE"] != '' 
  ? 
$arItem["VALUES"]["MAX"]["HTML_VALUE"]
 : 
$arItem["VALUES"]["MAX"]["VALUE"];

														?>
														<?php //var_dump( $arItem["VALUES"]);?>
                            		<div class="clear"></div>
                            		<div class="kombox-range clearfix"> 
                            			<div  
                            				data-value="<?= $min?>;<?= $max?>" 
                            				data-min="<?=$arItem["VALUES"]["MIN"]["VALUE"]?>" 
                            				data-max="<?=$arItem["VALUES"]["MAX"]["VALUE"]?>" 
                            				data-range-from="<?=$arItem["VALUES"]["MIN"]["FILTERED_VALUE"]?>" 
                            				data-range-to="<?=$arItem["VALUES"]["MAX"]["FILTERED_VALUE"]?>" 
                              			data-rel="range_<?=$arParams["FILTER_NAME"]?>_<?=$arItem["ID"]?>"
                                		id="range_<?=$arParams["FILTER_NAME"]?>_<?=$arItem["ID"]?><?=$show_all?"_FULL":""?>"
                            			>
                            			</div>
                            		</div>
                            	</li>
                            </ul>
														<!--<div class="b_input"><input type="text" name="" value="<?= $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>" class="val_min"></div>						
														<div class="b_sep"> - </div>
														<div class="b_input"><input type="text" name="" value="<?= $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>" class="val_max"></div>						
														
														<input type="hidden" name="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>" id="<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"]?><?=$show_all?"_FULL":""?>" value="<?= $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>" class="val_min_f">
														<input type="hidden" name="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>" id="<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"]?><?=$show_all?"_FULL":""?>" value="<?= $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"class="val_max_f">		-->																
														
												</div>
												<!--<div class="b_range_slide" data-steep="<?=$steep?>" data-min="<?=$arItem["VALUES"]["MIN"]["VALUE"]?>" data-max="<?=$arItem["VALUES"]["MAX"]["VALUE"]?>" data-rel="range_<?=$arParams["FILTER_NAME"]?>_<?=$arItem["ID"]?>" id="range_<?=$arParams["FILTER_NAME"]?>_<?=$arItem["ID"]?><?=$show_all?"_FULL":""?>"></div>	-->			
					
												<div class="clear"></div>
										</div>									
										<span class="bx_filter_container_modef"></span>
										<div class='clear'></div>
								</div>		
								<?
								break;					
								
						case  "C1":
								
								?>
								<div class="<?=$class?> b_box_small" data-group="<?=$arItem["GROUP_ID"]?>" data-prop-id="<?=$arItem["ID"]?>">
										<?foreach ($arItem["VALUES"] as $val => $ar):?>
												<div class="b_checkbox <?=$ar["CHECKED"]?"active":""?> <?=$ar["DISABLED"]?"noactive":""?>">												
														<div class="b"></div>
														<div class="b_label">
																<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																		<span class="bx_filter_icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
																<?endif?>																		
																<?//$ar["VALUE"]?>
																<?=$arItem["NAME"]?>
														</div>
														<input type="hidden" class="in_box" name="<?=$ar["CONTROL_NAME"]?>" id="<?=$ar["CONTROL_ID"]?><?=$show_all?"_FULL":""?>"  data-rel="<?=$ar["CONTROL_ID"]?>"  value="<?=$ar["CHECKED"]?"Y":"N"?>" >
														<?if($ar["DESCRIPTION"]):?><div class="q" data-text="<?=$ar["DESCRIPTION"]?>" ></div><?endif;?>
												</div>
										<?endforeach;?>			
										<span class="bx_filter_container_modef"></span>
										<div class='clear'></div>
								</div>								
								<?
								break;
								
								
						case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS												
						default	:								
								
								?>
								<div class="<?=$class?> <?=$arItem["DISPLAY_EXPANDED"]== "Y"?"active active_def":""?>"  data-group="<?=$arItem["GROUP_ID"]?>" data-prop-id="<?=$arItem["ID"]?>">								
										<div class="b_title">
												<div class="b_title_left"><?=$arItem["NAME"]?></div>
												<?if($arItem["DESCRIPTION"]):?><div class="q" data-text="<?=$arItem["DESCRIPTION"]?>" ></div><?endif;?>
												<div class="b"></div>																																											
										</div>
										<div class="clear"></div>
										<div class="b_hide">
												<?foreach ($arItem["VALUES"] as $val => $ar):
														//var_dump($ar["HTML_VALUE_ALT"], $ar["CONTROL_NAME_ALT"]);
														
														?>
														<div class="b_checkbox <?=$ar["CHECKED"]?"active":""?> <?=$ar["DISABLED"]?"noactive":""?>" data-role="label_<?=$ar["CONTROL_ID"]?>">												
																<div class="b"></div>
																<div class="b_label">
																		<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																				<span class="bx_filter_icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
																		<?endif?>																		
																		<?=$ar["VALUE"]?>
																</div>
																<input type="hidden" class="in_box" name="<?=$ar["CONTROL_NAME"]?>" id="<?=$ar["CONTROL_ID"]?><?=$show_all?"_FULL":""?>" data-rel="<?=$ar["CONTROL_ID"]?>" value="<?=$ar["CHECKED"]?"Y":"N"?>" >
																<?if($ar["DESCRIPTION"]):?><div class="q" data-text="<?=$ar["DESCRIPTION"]?>" ></div><?endif;?>
														</div>
												<?endforeach;?>				
												<div class="clear"></div>
										</div>										
										<span class="bx_filter_container_modef"></span>
										<div class='clear'></div>
								</div>															
								<?
								break;		
				}		
    } 
}
			
//ini_set('display_errors', 1);
if($show_all):
  foreach($arResult["ITEM_GROUPS"] as $key_group => $itemGroup):
    if(count($itemGroup["ITEMS"])): ?>
      <div class="b_filter_group" data-group="<?=$key_group;?>">
          <div class="b_filter_group_name"><?=$itemGroup['GROUP_NAME'];?></div>
          <? foreach($itemGroup["ITEMS"] as $key => $arItem):
          	b_filter_item_render($key, $arItem, $show_all, $arResult, $arParams, $itemGroup, $key_group);
          endforeach;		?>
      </div>
    <? endif;
  endforeach;
else:
  foreach($arResult["ITEMS"] as $key => $arItem):
    b_filter_item_render($key, $arItem, $show_all, $arResult, $arParams);
  endforeach;
endif;?>
