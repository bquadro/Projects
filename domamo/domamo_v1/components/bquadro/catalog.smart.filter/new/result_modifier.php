<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
		die();

$arParams["FILTER_VIEW_MODE"] = "vertical";
$arParams["POPUP_POSITION"] = "left";

//Подсказки к характеристикам
CModule::IncludeModule("iblock");
$arEnumDop = false;
$sql = "SELECT  * FROM `bq_property_param_enum`	";
$res = $DB->Query($sql);
while($resultEnum = $res->Fetch()){
		$arEnumDop[$resultEnum["ENUM_ID"]] = $resultEnum;																				
}		

 //added 16/01/2016
$arResult['ITEM_GROUPS'] = array();
$sql = "SELECT  bg.* FROM `bq_property_group` bg order by bg.group_weight asc";
$res = $DB->Query($sql);
while($result = $res->Fetch()){
		$arResult['ITEM_GROUPS'][$result["GROUP_ID"]] = $result;						
		$arResult['ITEM_GROUPS'][$result["GROUP_ID"]]["ITEMS"] = array();																		
}		

$arEnum = false;
$sql = "SELECT  bp.*, bg.GROUP_NAME FROM `bq_property_param`bp  LEFT JOIN `bq_property_group` bg ON bg.GROUP_ID = bp.GROUP_ID	"; //modified 16/01/2016
$res = $DB->Query($sql);
while($result = $res->Fetch()){
		$arEnum[$result["PROP_ID"]] = $result;																				
}		

foreach($arResult["ITEMS"] as $key=>$arItem):		
		$arResult["ITEMS"][$key]["SHOW_MAIN"] = (int)$arEnum[ $arItem["ID"] ] ["DOP_FILTR"] == 0 ? "N":"Y";
		if(isset($arEnum[$arItem["ID"]])){
				
				$tmp = $arEnum[$arItem["ID"]];
				
				$arResult["ITEMS"][$key]["GROUP_ID"] = isset($tmp["GROUP_ID"]) ? $tmp["GROUP_ID"] : null; //new 16/01/2016
				$arResult["ITEMS"][$key]["UNITS"] = isset($tmp["UNITS"]) ? $tmp["UNITS"] : null; //new 16/01/2016
				
				$arResult["ITEMS"][$key]["DESCRIPTION"] = $tmp["DESCRIPTION_TYPE"]!="html"?nl2br($tmp["DESCRIPTION"]):$tmp["DESCRIPTION"];
				$arResult["ITEMS"][$key]["DESCRIPTION"] = $arResult["ITEMS"][$key]["DESCRIPTION"]==""?false:$arResult["ITEMS"][$key]["DESCRIPTION"];
				if($arResult["ITEMS"][$key]["DESCRIPTION"]){
							$arResult["ITEMS"][$key]["DESCRIPTION"] = "<div class=\"b_name\">{$arResult["ITEMS"][$key]["NAME"]}</div>".$arResult["ITEMS"][$key]["DESCRIPTION"];
							$arResult["ITEMS"][$key]["DESCRIPTION"] = str_replace('"',	"'",	$arResult["ITEMS"][$key]["DESCRIPTION"]);
				}
				if($arItem["PROPERTY_TYPE"] == "L"){
						foreach($arItem["VALUES"] as $k=>$val){
								if(isset($arEnumDop[$k])){
										$arResult["ITEMS"][$key]["VALUES"][$k]["DESCRIPTION"] = $arEnumDop[$k]["DESCRIPTION_TYPE"]!="html"?nl2br($arEnumDop[$k]["DESCRIPTION"]):$arEnumDop[$k]["DESCRIPTION"];
										$arResult["ITEMS"][$key]["VALUES"][$k]["DESCRIPTION"] = $arResult["ITEMS"][$key]["VALUES"][$k]["DESCRIPTION"]==""?false:$arResult["ITEMS"][$key]["VALUES"][$k]["DESCRIPTION"];
										if($arResult["ITEMS"][$key]["VALUES"][$k]["DESCRIPTION"]){
												$arResult["ITEMS"][$key]["VALUES"][$k]["DESCRIPTION"] = "<div class=\"b_name\">{$arResult["ITEMS"][$key]["VALUES"][$k]["VALUE"]}</div>".$arResult["ITEMS"][$key]["VALUES"][$k]["DESCRIPTION"];
												$arResult["ITEMS"][$key]["VALUES"][$k]["DESCRIPTION"] = str_replace('"',	"'",	$arResult["ITEMS"][$key]["VALUES"][$k]["DESCRIPTION"]);
										}
										
								}
						}
				}
		}
		
		//added 16/01/2016 (Создаем группы свойств)
		if(isset($arResult["ITEMS"][$key]["GROUP_ID"]) ){
  		$arResult['ITEM_GROUPS'][$arResult["ITEMS"][$key]["GROUP_ID"]]['ITEMS'][$key] = $arResult["ITEMS"][$key];
		} else {
  		$arResult['ITEM_GROUPS'][6]['ITEMS'][$key] = $arResult["ITEMS"][$key];
		}
		
endforeach;

//---------
foreach	($arResult["ITEMS"]	as	$key	=>	$arItem):
		if	(isset($arItem["PRICE"]))	{
				$arItem["DISPLAY_TYPE"]	=	"A";
				$arResult["ITEMS"][$key]["DISPLAY_TYPE"] = "A";
		}
		if(	($arItem["DISPLAY_TYPE"]	==	"A"	&&	(isset($arItem["VALUES"]["MIN"]["VALUE"])	|| isset($arItem["VALUES"]["MAX"]["VALUE"])	||	$arItem["VALUES"]["MIN"]["VALUE"]	==	$arItem["VALUES"]["MAX"]["VALUE"]))
				|| empty($arItem["VALUES"]) ){
				
				//unset($arResult["ITEMS"]	[ $key ]);
		}
endforeach;



