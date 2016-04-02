<?

if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)
		die();


\Bitrix\Main\Loader::IncludeModule("bq.options");

use	\Bq\Options;

$arOptionStatus	=	\Bq\Options\OptionsTable::getStatusList();
$options	=	new	\Bq\Options\OptionsTable();
$basketOptions	=	array();
$basketProduct	=	array();
foreach	($arResult["GRID"]["ROWS"]	as	$k	=>	$arItem):
		if	($arItem["MODULE"]	==	"bq.options")	{
				foreach	($arItem["PROPS"]	as	$props)	{
						if	($props["CODE"]	!=	"")
								$arItem["props_"	.	$props["CODE"]]	=	$props["VALUE"];
				}
				$basketOptions[$arItem["props_product_id"]][$arItem["PRODUCT_ID"]]	=	$arItem;
				unset($arResult["GRID"]["ROWS"][$k]);
		}else{
				$basketProduct[$arItem["PRODUCT_ID"]] = $arItem;
		}
endforeach;


foreach	($arResult["GRID"]["ROWS"]	as	$k	=>	$arItem):
		$param	=	array(
						"ID"	=>	$arItem["PRODUCT_ID"],
						"SECTION_ID"	=>	array($arItem["CATALOG"]["SECTION_ID"]),
						"COMPANY_ID"	=>	$arItem["PROPERTY_COMPANY_CODE_VALUE"],
						"ARCHITECT_ID"	=>	$arItem["PROPERTY_ARCHITECT_CODE_VALUE"],
		);
		$arResult["GRID"]["ROWS"][$k]["OPTIONS"]	=	$options->getByProduct($param);
		foreach	($arResult["GRID"]["ROWS"][$k]["OPTIONS"]	as	$id	=>	$ar)	{
				foreach	($ar	as	$k2	=>	$arOptions)	{
						if	(is_array($basketOptions[$arItem["PRODUCT_ID"]][$arOptions["ID"]]))	{
								$arResult["GRID"]["ROWS"][$k]["OPTIONS"][$id][$k2]["IN_BASKET"]	=	"Y";
						}	else	{
								$arResult["GRID"]["ROWS"][$k]["OPTIONS"][$id][$k2]["IN_BASKET"]	=	"N";
						}
				}
		}

endforeach;

//Если в корзине остались опции, но при этом проект удалён \ снят с продажи
$need_reload = false;
foreach	($basketOptions as $project_id => $ar ){
		if(!isset($basketProduct[$project_id])){
				foreach	($ar as $item){
						CSaleBasket::Delete($item["ID"]);
				}
				$need_reload = true;
		}		
}
if($need_reload){
		header("Location: ?reload=Y");
		die();
}


//$arResult["allSum"]	=	0;
foreach	($arResult["ITEMS"]["AnDelCanBuy"]	as	$k	=>	$arItem):
		if	($arItem["MODULE"]	==	"bq.options")	{
				unset($arResult["ITEMS"]["AnDelCanBuy"][$k]);
				continue;
		}
		$arResult["allSum"]	+=	$arItem["PRICE"];
endforeach;

//$arResult["allSum_FORMATED"] = catalog_price_format($arResult["allSum"]);


