<?
\Bitrix\Main\Loader::IncludeModule("bq.options");

use	\Bq\Options;

$arOptionStatus	=	\Bq\Options\OptionsTable::getStatusList();

$options = new \Bq\Options\OptionsTable();

foreach	($arResult["GRID"]["ROWS"]	as	$k	=>	$arItem):
		if($arItem["MODULE"] == "bq.options"){
				unset($arResult["GRID"]["ROWS"][$k]);
		}
endforeach;

foreach	($arResult["GRID"]["ROWS"]	as	$k	=>	$arItem):
		
		$param = array(
						"ID" => $arItem["PRODUCT_ID"],
						"SECTION_ID" => $arItem["CATALOG"]["SECTION_ID"],
						"COMPANY_ID" => $arItem["PROPERTY_COMPANY_CODE_VALUE"],
						"ARCHITECT_ID" => $arItem["PROPERTY_ARCHITECT_CODE_VALUE"],
		);
		$arResult["GRID"]["ROWS"][$k]["OPTIONS"]	=	$options->getByProduct($param);
endforeach;
