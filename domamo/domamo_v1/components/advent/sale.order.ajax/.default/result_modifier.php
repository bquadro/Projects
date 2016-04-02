<?
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)
		die();


\Bitrix\Main\Loader::IncludeModule("bq.options");

use	\Bq\Options;

$arOptionStatus	=	\Bq\Options\OptionsTable::getStatusList();

$options = new \Bq\Options\OptionsTable();

$basketOptions = array();

foreach	($arResult["GRID"]["ROWS"]	as	$k	=>	$arRow):
		$arItem = $arRow["data"];
		if($arItem["MODULE"] == "bq.options"){
				
				
				
				foreach	($arItem["PROPS"] as $props){
						if($props["CODE"] != "")
								$arItem["props_".$props["CODE"]] = $props["VALUE"];
				}
				$basketOptions[$arItem["props_product_id"]][$arItem["PRODUCT_ID"]] = $arItem;
				
				unset($arResult["GRID"]["ROWS"][$k]);
				
		}
endforeach;







foreach	($arResult["GRID"]["ROWS"]	as	$k	=>	$arRow):
		$arItem = $arRow["data"];
		
		$param = array(
						"ID" => $arItem["PRODUCT_ID"],
						"SECTION_ID" => $arItem["CATALOG"]["SECTION_ID"],
						"COMPANY_ID" => $arItem["CATALOG"]["PROPERTIES"]["COMPANY"]["VALUE"],
						"ARCHITECT_ID" => $arItem["CATALOG"]["PROPERTIES"]["ARCHITECT"]["VALUE"],
						//"ARCHITECT_ID" => $arItem["PROPERTY_ARCHITECT_CODE_VALUE"],
		);
		
		$arResult["GRID"]["ROWS"][$k]["OPTIONS"]	=	$options->getByProduct($param);
		
		foreach	($arResult["GRID"]["ROWS"][$k]["OPTIONS"] as $id=>$ar){
				foreach	($ar as $k2=>$arOptions){						
						if(is_array($basketOptions[$arItem["PRODUCT_ID"]][$arOptions["ID"]] )){
								$arResult["GRID"]["ROWS"][$k]["OPTIONS"][$id][$k2]["IN_BASKET"] = "Y";
						}else{
								$arResult["GRID"]["ROWS"][$k]["OPTIONS"][$id][$k2]["IN_BASKET"] = "N";
						}
				}
		}
		
endforeach;





