<?
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)
		die();
$arTag	=	false;	
use	Bitrix\Main\Loader;
use	Bitrix\Main\ModuleManager;

$this->setFrameMode(true);
global ${$arParams["FILTER_NAME"]};
$arrFiltrCatalogMain = &${$arParams["FILTER_NAME"]};
		

global $USER;
if ($USER->IsAdmin()) {
  $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/catalog_filtr_new.js");
} else {
  $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/catalog_filtr.js");
}

$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/catalog_search.js");

if(isset($_GET["promo"]) || isset($_GET["sort"]) || isset($_GET["order"])){
  $APPLICATION->SetPageProperty("robots", "noindex, follow");                      
}

switch	($_GET["promo"])	{
		case	"new":
				$arrFiltrCatalogMain["PROPERTY"]["STATUS"]	=	1;
				break;
		case	"best":
				$arrFiltrCatalogMain["PROPERTY"]["STATUS"]	=	2;
				break;
		case	"sale":
				$arrFiltrCatalogMain["PROPERTY"]["STATUS"]	=	3;
				break;
}

switch	($_GET["sort"])	{
		case	"price":
				$sort	=	"PROPERTY_PRICE_FULL";
				break;
		case	"raiting":
				$sort	=	"sort";
				break;
		case	"area":
				$sort	=	"PROPERTY_AREA1";
				break;
		case	"room":
				$sort	=	"PROPERTY_BEDROOM";
				break;
		default	:
				$sort	=	"sort";
				break;
}
switch	($_GET["order"])	{
		case	"desc":
				$order	=	"desc";
				break;
		default	:
				$order	=	"asc";
				break;
}

$arParams['FILTER_VIEW_MODE']	=	'VERTICAL';
$arParams['USE_FILTER']	=	(isset($arParams['USE_FILTER'])	&&	$arParams['USE_FILTER']	==	'Y'	?	'Y'	:	'N');



if	($arParams['USE_FILTER']	==	'Y')	{

		$arFilter	=	array(
						"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
						"ACTIVE"	=>	"Y",
						"GLOBAL_ACTIVE"	=>	"Y",
		);

		if	(0	<	intval($arResult["VARIABLES"]["SECTION_ID"]))	{
				$arFilter["ID"]	=	$arResult["VARIABLES"]["SECTION_ID"];
		}	elseif	(''	!=	$arResult["VARIABLES"]["SECTION_CODE"])	{
				$arFilter["=CODE"]	=	$arResult["VARIABLES"]["SECTION_CODE"];
		}

		$obCache	=	new	CPHPCache();
		if	($obCache->InitCache(36000,	serialize($arFilter),	"/iblock/catalog"))	{
				$arCurSection	=	$obCache->GetVars();
		}	elseif	($obCache->StartDataCache())	{

				$arCurSection	=	array();
				if	(Loader::includeModule("iblock"))	{
						$dbRes	=	CIBlockSection::GetList(array(),	$arFilter,	false,	array("ID"));

						if	(defined("BX_COMP_MANAGED_CACHE"))	{
								global	$CACHE_MANAGER;
								$CACHE_MANAGER->StartTagCache("/iblock/catalog");

								if	($arCurSection	=	$dbRes->Fetch())	{
										$CACHE_MANAGER->RegisterTag("iblock_id_"	.	$arParams["IBLOCK_ID"]);
								}
								$CACHE_MANAGER->EndTagCache();
						}	else	{
								if	(!$arCurSection	=	$dbRes->Fetch())
										$arCurSection	=	array();
						}
				}
				$obCache->EndDataCache($arCurSection);
		}
		if	(!isset($arCurSection))	{
				$arCurSection	=	array();
		}
		//$arrFiltrCatalogMain["PROPERTY"]["PTYPE"] = 10;
		CModule::IncludeModule("bq.tags");
		$arTag = false;
		if	(isset($arResult["VARIABLES"]["TAG_CODE"])	&&	!isset($_GET["set_filter"]))	{
				CModule::IncludeModule("bq.dev");				
				
				$param	=	array(
								"select"	=>	array("*"),
								"filter"	=>	array(
												"ACTIVE"	=>	"Y",
												"SECTION_ID"	=>	$arCurSection['ID'],
												"CODE"	=>	$arResult["VARIABLES"]["TAG_CODE"],
								),
								"order"	=>	array("SORT"	=>	"ASC"),
				);
				$res	=	Bq\Tags\TagsTable::getList($param);
				$arTag	=	$res->fetch();
				if($arTag == false){
						echo "404";
						die();
				}				
				//$arTag = bqTag::GetFiltrParam(array("SECTION_ID"=>$arCurSection['ID'], "TAG_CODE"=>$arResult["VARIABLES"]["TAG_CODE"]));
				//bqTag::farcetFiltr($arTag["PROPS"], array("FILTER_NAME" => $arParams["FILTER_NAME"]));								
		}elseif(isset($arResult["VARIABLES"]["TAG_CODE"])){
				
				$page	=	$APPLICATION->GetCurPageParam();
				//По возможности делать редирект
				if	(preg_match("/\/catalog\/([a-z0-9_-]+)\/([a-z0-9_-]+)\/(.*?)$/",	$page,	$arRes))	{
						if(strlen($arRes[3])<200)
								LocalRedirect("/catalog/".$arResult["VARIABLES"]["SECTION_CODE"]."/".$arRes[3]);
				}
		}
		

global $USER;
if ($USER->IsAdmin()) {


		$APPLICATION->IncludeComponent(
										"bquadro:catalog.smart.filter",	"new",	array(
						"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
						"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
						"SECTION_ID"	=>	$arCurSection['ID'],
						"FILTER_NAME"	=>	$arParams["FILTER_NAME"],
						"PRICE_CODE"	=>	$arParams["PRICE_CODE"],
						"CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
						"CACHE_TIME"	=>	$arParams["CACHE_TIME"],
						"CACHE_GROUPS"	=>	$arParams["CACHE_GROUPS"],
						"SAVE_IN_SESSION"	=>	"N",
						"FILTER_VIEW_MODE"	=>	$arParams["FILTER_VIEW_MODE"],
						"XML_EXPORT"	=>	"Y",
						"SECTION_TITLE"	=>	"NAME",
						"SECTION_DESCRIPTION"	=>	"DESCRIPTION",
						'HIDE_NOT_AVAILABLE'	=>	$arParams["HIDE_NOT_AVAILABLE"],
						"SECTION_TAG" =>$arTag,
						"TEMPLATE_THEME"	=>	$arParams["TEMPLATE_THEME"]
										),	false,	array('HIDE_ICONS'	=>	'Y'));
	} else {

		$APPLICATION->IncludeComponent(
										"bquadro:catalog.smart.filter",	"",	array(
						"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
						"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
						"SECTION_ID"	=>	$arCurSection['ID'],
						"FILTER_NAME"	=>	$arParams["FILTER_NAME"],
						"PRICE_CODE"	=>	$arParams["PRICE_CODE"],
						"CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
						"CACHE_TIME"	=>	$arParams["CACHE_TIME"],
						"CACHE_GROUPS"	=>	$arParams["CACHE_GROUPS"],
						"SAVE_IN_SESSION"	=>	"N",
						"FILTER_VIEW_MODE"	=>	$arParams["FILTER_VIEW_MODE"],
						"XML_EXPORT"	=>	"Y",
						"SECTION_TITLE"	=>	"NAME",
						"SECTION_DESCRIPTION"	=>	"DESCRIPTION",
						'HIDE_NOT_AVAILABLE'	=>	$arParams["HIDE_NOT_AVAILABLE"],
						"SECTION_TAG" =>$arTag,
						"TEMPLATE_THEME"	=>	$arParams["TEMPLATE_THEME"]
										),	false,	array('HIDE_ICONS'	=>	'Y'));
	}									
}

?>
<div class="b_wrapper">
		<div class="b_catalog">		
				<div class="b_catalog_list">																		
<?
$intSectionID	=	$APPLICATION->IncludeComponent(
								"bitrix:catalog.section",	"",	array(
				"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
				"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
				"ELEMENT_SORT_FIELD"	=>	$sort,
				"ELEMENT_SORT_ORDER"	=>	$order,
				"ELEMENT_SORT_FIELD2"	=>	$arParams["ELEMENT_SORT_FIELD2"],
				"ELEMENT_SORT_ORDER2"	=>	$arParams["ELEMENT_SORT_ORDER2"],
				"PROPERTY_CODE"	=>	$arParams["LIST_PROPERTY_CODE"],
				"META_KEYWORDS"	=>	$arParams["LIST_META_KEYWORDS"],
				"META_DESCRIPTION"	=>	$arParams["LIST_META_DESCRIPTION"],
				"BROWSER_TITLE"	=>	$arParams["LIST_BROWSER_TITLE"],
				"INCLUDE_SUBSECTIONS"	=>	$arParams["INCLUDE_SUBSECTIONS"],
				"BASKET_URL"	=>	$arParams["BASKET_URL"],
				"ACTION_VARIABLE"	=>	$arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE"	=>	$arParams["PRODUCT_ID_VARIABLE"],
				"SECTION_ID_VARIABLE"	=>	$arParams["SECTION_ID_VARIABLE"],
				"PRODUCT_QUANTITY_VARIABLE"	=>	$arParams["PRODUCT_QUANTITY_VARIABLE"],
				"PRODUCT_PROPS_VARIABLE"	=>	$arParams["PRODUCT_PROPS_VARIABLE"],
				"FILTER_NAME"	=>	$arParams["FILTER_NAME"],
				"CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
				"CACHE_TIME"	=>	$arParams["CACHE_TIME"],
				"CACHE_FILTER"	=>	$arParams["CACHE_FILTER"],
				"CACHE_GROUPS"	=>	$arParams["CACHE_GROUPS"],
				"SET_TITLE"	=>	$arParams["SET_TITLE"],
				"SET_STATUS_404"	=>	$arParams["SET_STATUS_404"],
				"DISPLAY_COMPARE"	=>	$arParams["USE_COMPARE"],
				"PAGE_ELEMENT_COUNT"	=>	$arParams["PAGE_ELEMENT_COUNT"],
				"LINE_ELEMENT_COUNT"	=>	$arParams["LINE_ELEMENT_COUNT"],
				"PRICE_CODE"	=>	$arParams["PRICE_CODE"],
				"USE_PRICE_COUNT"	=>	$arParams["USE_PRICE_COUNT"],
				"SHOW_PRICE_COUNT"	=>	$arParams["SHOW_PRICE_COUNT"],
				"PRICE_VAT_INCLUDE"	=>	$arParams["PRICE_VAT_INCLUDE"],
				"USE_PRODUCT_QUANTITY"	=>	$arParams['USE_PRODUCT_QUANTITY'],
				"ADD_PROPERTIES_TO_BASKET"	=>	(isset($arParams["ADD_PROPERTIES_TO_BASKET"])	?	$arParams["ADD_PROPERTIES_TO_BASKET"]	:	''),
				"PARTIAL_PRODUCT_PROPERTIES"	=>	(isset($arParams["PARTIAL_PRODUCT_PROPERTIES"])	?	$arParams["PARTIAL_PRODUCT_PROPERTIES"]	:	''),
				"PRODUCT_PROPERTIES"	=>	$arParams["PRODUCT_PROPERTIES"],
				"DISPLAY_TOP_PAGER"	=>	$arParams["DISPLAY_TOP_PAGER"],
				"DISPLAY_BOTTOM_PAGER"	=>	$arParams["DISPLAY_BOTTOM_PAGER"],
				"PAGER_TITLE"	=>	$arParams["PAGER_TITLE"],
				"PAGER_SHOW_ALWAYS"	=>	$arParams["PAGER_SHOW_ALWAYS"],
				"PAGER_TEMPLATE"	=>	$arParams["PAGER_TEMPLATE"],
				"PAGER_DESC_NUMBERING"	=>	$arParams["PAGER_DESC_NUMBERING"],
				"PAGER_DESC_NUMBERING_CACHE_TIME"	=>	$arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
				"PAGER_SHOW_ALL"	=>	$arParams["PAGER_SHOW_ALL"],
				"OFFERS_CART_PROPERTIES"	=>	$arParams["OFFERS_CART_PROPERTIES"],
				"OFFERS_FIELD_CODE"	=>	$arParams["LIST_OFFERS_FIELD_CODE"],
				"OFFERS_PROPERTY_CODE"	=>	$arParams["LIST_OFFERS_PROPERTY_CODE"],
				"OFFERS_SORT_FIELD"	=>	$arParams["OFFERS_SORT_FIELD"],
				"OFFERS_SORT_ORDER"	=>	$arParams["OFFERS_SORT_ORDER"],
				"OFFERS_SORT_FIELD2"	=>	$arParams["OFFERS_SORT_FIELD2"],
				"OFFERS_SORT_ORDER2"	=>	$arParams["OFFERS_SORT_ORDER2"],
				"OFFERS_LIMIT"	=>	$arParams["LIST_OFFERS_LIMIT"],
				"SECTION_ID"	=>	$arResult["VARIABLES"]["SECTION_ID"],
				"SECTION_CODE"	=>	$arResult["VARIABLES"]["SECTION_CODE"],
				"SECTION_URL"	=>	$arResult["FOLDER"]	.	$arResult["URL_TEMPLATES"]["section"],
				"DETAIL_URL"	=>	$arResult["FOLDER"]	.	$arResult["URL_TEMPLATES"]["element"],
				'CONVERT_CURRENCY'	=>	$arParams['CONVERT_CURRENCY'],
				'CURRENCY_ID'	=>	$arParams['CURRENCY_ID'],
				'HIDE_NOT_AVAILABLE'	=>	$arParams["HIDE_NOT_AVAILABLE"],
				'LABEL_PROP'	=>	$arParams['LABEL_PROP'],
				'ADD_PICT_PROP'	=>	$arParams['ADD_PICT_PROP'],
				'PRODUCT_DISPLAY_MODE'	=>	$arParams['PRODUCT_DISPLAY_MODE'],
				'OFFER_ADD_PICT_PROP'	=>	$arParams['OFFER_ADD_PICT_PROP'],
				'OFFER_TREE_PROPS'	=>	$arParams['OFFER_TREE_PROPS'],
				'PRODUCT_SUBSCRIPTION'	=>	$arParams['PRODUCT_SUBSCRIPTION'],
				'SHOW_DISCOUNT_PERCENT'	=>	$arParams['SHOW_DISCOUNT_PERCENT'],
				'SHOW_OLD_PRICE'	=>	$arParams['SHOW_OLD_PRICE'],
				'MESS_BTN_BUY'	=>	$arParams['MESS_BTN_BUY'],
				'MESS_BTN_ADD_TO_BASKET'	=>	$arParams['MESS_BTN_ADD_TO_BASKET'],
				'MESS_BTN_SUBSCRIBE'	=>	$arParams['MESS_BTN_SUBSCRIBE'],
				'MESS_BTN_DETAIL'	=>	$arParams['MESS_BTN_DETAIL'],
				'MESS_NOT_AVAILABLE'	=>	$arParams['MESS_NOT_AVAILABLE'],
				'TEMPLATE_THEME'	=>	(isset($arParams['TEMPLATE_THEME'])	?	$arParams['TEMPLATE_THEME']	:	''),
				"ADD_SECTIONS_CHAIN"	=>	"Y",
				'ADD_TO_BASKET_ACTION'	=>	$basketAction,
				"SECTION_TAG" =>$arTag,
				//"SECTION_DESCRIPTION" => $arTag["DESCRIPTION"],
				'SHOW_CLOSE_POPUP'	=>	isset($arParams['COMMON_SHOW_CLOSE_POPUP'])	?	$arParams['COMMON_SHOW_CLOSE_POPUP']	:	'',
				'COMPARE_PATH'	=>	$arResult['FOLDER']	.	$arResult['URL_TEMPLATES']['compare']
								),	$component
);
?>	


									
				</div>

				<div class="b_right_block no_select">
						<div class="b_search_id">
								<div class="b_input">
										<input type="text" value="" name="q" id="searchID">
										<div class="placeholder">Поиск по номеру проекта</div>
								</div>
								<input type="submit" value="Ок" class="s_btn">
								<div class="b_search_result"></div>
						</div>
						<div class="clear"></div>
								<?	$APPLICATION->ShowViewContent("area_filtr")	?>
						<div class="clear"></div>			
				</div>
				<div class="b_big_filtr ">
						<div class="b_data_box">
								<div class="b_title">Расширенный подбор домов</div>
								<div class="b_close"></div>
								<div class="b_close_small"><span></span></div>
								<div class="clear"></div>
								<div class="b_full_filtr no_select">										
										<?	$APPLICATION->ShowViewContent("area_filtr_full")	?>
								</div>
								<div class="clear"></div>
						</div>
				</div>
				<div class="clear"></div>
		</div>						
</div>						
<?
//set title
if($arTag){		
		$APPLICATION->SetPageProperty("keywords", $arTag["META_KEYWORDS"]);
		$APPLICATION->SetPageProperty("description", $arTag["META_DESCRIPTION"]);
		$APPLICATION->SetPageProperty("title", $arTag["META_TITLE"]);		
		if($arTag["NOINDEX"] == "Y")
				$APPLICATION->SetPageProperty("robots", "noindex, nofollow");


				$parent_ID = (int)$arTag["ID"];
				$i = 0;
				do{
						
						$sql	=	"SELECT 
								bq_tags_list.* ,
								bq_tags_parent.PARENT_ID
						FROM `bq_tags_list`				
						LEFT JOIN bq_tags_parent ON ( bq_tags_parent.TAG_ID =  bq_tags_list.ID )
						WHERE 
								bq_tags_list.SECTION_ID = '{$arCurSection['ID']}' AND 						
								bq_tags_list.ID = '"	.$parent_ID.	"'					  						
						ORDER BY SORT ASC LIMIT 1";
						$res	=	$DB->Query($sql);
						if	($_tag	=	$res->GetNext())	{
								$paretn_tag[]	=	$_tag;
								$parent_ID = (int)$_tag["PARENT_ID"];
						}else{
								$parent_ID = 0;
						}				
						$i++;
				}while($i<=3 && $parent_ID>0);

				if($paretn_tag && is_array($paretn_tag) && count($paretn_tag) > 1){
						$paretn_tag = array_reverse($paretn_tag, true);
				}
				

				
		$k	=	0;
		foreach	($paretn_tag	as	$t):
				$k++;
				if	($k	!=	count($paretn_tag))	{
						$APPLICATION->AddChainItem($t["NAME_SHOT"], "/catalog/{$arResult["VARIABLES"]["SECTION_CODE"]}/{$t["CODE"]}/");
				}
		endforeach;
		
								
		
}

?>