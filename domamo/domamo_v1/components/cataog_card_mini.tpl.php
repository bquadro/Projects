<?
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)
		die();	
global $arWatermark, $arWatermark2;
global $FAVORITES;

foreach	($arResult['ITEMS']	as	$key	=>	$arElement)	{
		if(!$no_component)	 $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
        if(!$no_component)	$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
				
				if(!$arElement["PREVIEW_PICTURE"])
						$arElement["PREVIEW_PICTURE"] = $arElement["DETAIL_PICTURE"];                
				if(!$arElement["PREVIEW_PICTURE"])
						$arElement["PREVIEW_PICTURE"] = array("src" => "/images/no_photo.png");
				else
						$arElement["PREVIEW_PICTURE"] = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"],array("width" => 305,   "height" => 204), BX_RESIZE_IMAGE_PROPORTIONAL, false, array($arWatermark, $arWatermark2));         
				
				$arStatusXML = $arElement["PROPERTIES"]["STATUS"]["VALUE_XML_ID"];
				
				$area = $arElement["PROPERTIES"]["AREA1"]["VALUE"] !="" ?$arElement["PROPERTIES"]["AREA1"]["VALUE"]:"";
				$area .= ($arElement["PROPERTIES"]["AREA1"]["VALUE"] !="" && $arElement["PROPERTIES"]["AREA2"]["VALUE"] != "")?"/":"";
				$area .= $arElement["PROPERTIES"]["AREA2"]["VALUE"] != "" ?$arElement["PROPERTIES"]["AREA2"]["VALUE"]:"";				
				$area = $area!=""?$area."м&#178;":false;
				
				if( in_array("project",	$arElement["PROPERTIES"]["PTYPE"]["VALUE_XML_ID"] )){
						$arElement["PROPERTIES"]["PTYPE"]["VALUE_XML_ID"] = false;
						$arElement["PROPERTIES"]["PTYPE"]["VALUE"] = false;
				}
				
				$price_full = false;										
				if($arElement["PROPERTIES"]["PRICE_FULL"]["VALUE"])
						$price_full = catalog_price_format( $arElement["PROPERTIES"]["PRICE_FULL"]["VALUE"]);
        if($arElement["PROPERTIES"]["PRICE_CALC"]["VALUE_ENUM_ID"] == '222')
        		$price_full	=	"~"	.	$price_full;
				
				$mat = false;
				$matArray = false;
				if(is_array($arElement["PROPERTIES"]["MATERIAL"]["VALUE"]) && count($arElement["PROPERTIES"]["MATERIAL"]["VALUE"])>1){						
						$price_max = 0;
						foreach	($arElement["PROPERTIES"]["MATERIAL"]["VALUE"] as $k=>$val){
								$matArray[] = $arResult["MATERIAL"][$val]["UF_NAME"];
								if($arResult["MATERIAL"][$val]["UF_PRICE"] > $price_max)
										$price_max = $arResult["MATERIAL"][$val]["UF_PRICE"];
						}
						if($price_full == FALSE && $arElement["PROPERTIES"]["AREA1"]["VALUE"]){
								$price_full = "~".catalog_price_format( $price_max * $arElement["PROPERTIES"]["AREA1"]["VALUE"] );
						}
				}elseif(is_array($arElement["PROPERTIES"]["MATERIAL"]["VALUE"]) && count($arElement["PROPERTIES"]["MATERIAL"]["VALUE"])==1){
						$mat = $arResult["MATERIAL"][ $arElement["PROPERTIES"]["MATERIAL"]["VALUE"][0] ];
						if($price_full == false && $mat["UF_PRICE"] > 0 && $arElement["PROPERTIES"]["AREA1"]["VALUE"] > 0){
								$price_full = "~".catalog_price_format( $mat["UF_PRICE"] * $arElement["PROPERTIES"]["AREA1"]["VALUE"] );
						}
				}

				?>
				<div class="item_block">
						<a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="item" target="_blank" <?=	!$no_component ?	'id="'.$this->GetEditAreaId($arElement['ID']).'"' :'';	?>>
								<div class="img">
										<img src="<?=$arElement["PREVIEW_PICTURE"]["src"]?>">
										<span class="checkbox comparison" title="Добавить к сравнению" data-rel="<?=$arElement["ID"]?>"></span>
										<span class="projects_heart <?= in_array( $arElement["ID"], $FAVORITES)?"active":""?>" title="Избранные проекты" data-rel="<?=$arElement["ID"]?>"></span>
										<div class="item_bb_block">
												<?if(in_array("NEW",	$arStatusXML)):?><span class="projects_new" title="Новинка">new</span><?endif;?>
												<?if(in_array("BEST",	$arStatusXML)):?><span class="projects_best" title="Бестселлер">best</span><?endif;?>
												<?if(in_array("SALE",	$arStatusXML)):?><span class="projects_discount" title="Участвует в акции">%</span><?endif;?>
										</div>
										<div class="item_img_bottom_line <?= ($arElement["PROPERTIES"]["PTYPE"]["VALUE"])?"b_type":""?> ">
												<?if($arElement["PROPERTIES"]["CODE"]["VALUE"]):?><span class="projects_number"><?=$arElement["PROPERTIES"]["CODE"]["VALUE"]?></span><?endif;?>
												<?if($area):?><span class="projects_area"><?=$area?></span><?endif;?>
												<?if($arElement["PROPERTIES"]["PTYPE"]["VALUE"]):?><span class="projects_type"><?=$arElement["PROPERTIES"]["PTYPE"]["VALUE"][0]?></span><?endif;?>										
										</div>
								</div>
								<div class="bottom_block">
										<?if($arElement["PROPERTIES"]["BEDROOM"]["VALUE"]):?><span class="var" title="Количество спален">спальн.<span><?=$arElement["PROPERTIES"]["BEDROOM"]["VALUE"]?></span></span><?endif;?>
										<?if($arElement["PROPERTIES"]["PROJECT_COUNT"]["VALUE"] && (int)$arElement["PROPERTIES"]["PROJECT_COUNT"]["VALUE"]>1):?><span class="var" title="Варианты проекта">вар.<span><?=$arElement["PROPERTIES"]["PROJECT_COUNT"]["VALUE"]?></span></span><?endif;?>
										<?if($mat):?><span class="var material" title="Материал стен: <?=$mat["UF_NAME"];?>">матер.<span><img src="<?=CFile::GetPath($mat["UF_FILE"]);?>"></span></span><?endif;?>
										<?if($matArray):?><span class="var material" title="Материал стен: <?=implode(", ", $matArray);?>">матер.<span><img src="/images/material_extra.png"></span></span><?endif;?>
										<?if($price_full):?><span class="cost"><span class="cost_title">Стоимость<br>строительства</span><span class="price"><?=$price_full?></span></span><?endif;?>
										<div class="clear"></div>
								</div>																				
								<span class="comments __active">Нет комментариев</span>
								<!-- <span class="count">2 построенных дома</span> !-->
						</a>
				<?if($arResult['SHOW_NAME'] == "Y"):?>
						<div class="clear"></div>
						<div class="b_name"><?=$arElement["NAME"]?></div>
				<?endif;?>
				</div>
				<?
		}
		?><div class="clear"></div><?