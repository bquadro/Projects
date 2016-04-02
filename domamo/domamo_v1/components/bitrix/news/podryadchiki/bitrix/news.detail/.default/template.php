<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<p class="news-detail">
		<?if($arResult["PROPERTIES"]["PHONE"]["VALUE"]):?>Телефон: &nbsp;&nbsp; <?=$arResult["PROPERTIES"]["PHONE"]["VALUE"]?><br><?endif;?>
		<?if($arResult["PROPERTIES"]["SKYPE"]["VALUE"]):?>Skype: &nbsp;&nbsp;<a href="skype:<?=$arResult["PROPERTIES"]["SKYPE"]["VALUE"]?>" class="skype"><?=$arResult["PROPERTIES"]["SKYPE"]["VALUE"]?></a><br><?endif;?>										
		<?echo $arResult["PREVIEW_TEXT"];?>			
</p>

<div class="b_projet_desc">
		<?		
	
		global $arrFilterLots;
		$arrFilterLots["PROPERTY_COMPANY"] = $arResult["ID"];		
		$APPLICATION->IncludeComponent("bitrix:catalog.section", "project_lots", array(
			"IBLOCK_TYPE" => "catalog",
			"IBLOCK_ID" => "2",
			"SECTION_ID" => "false",
			"SECTION_CODE" => "",
			"SECTION_USER_FIELDS" => array(
				0 => "",
				1 => "",
			),
			"ELEMENT_SORT_FIELD" => "sort",
			"ELEMENT_SORT_ORDER" => "asc",
			"FILTER_NAME" => "arrFilterLots",
			"INCLUDE_SUBSECTIONS" => "Y",
			"SHOW_ALL_WO_SECTION" => "Y",
			"PAGE_ELEMENT_COUNT" => "36",
			"LINE_ELEMENT_COUNT" => "1",
			"PROPERTY_CODE" => array(
				0 => "STATUS",
				1 => "",
			),
			"OFFERS_LIMIT" => "0",
			"SECTION_URL" => "",
			"DETAIL_URL" => "",
			"BASKET_URL" => "/personal/basket.php",
			"ACTION_VARIABLE" => "action",
			"PRODUCT_ID_VARIABLE" => "id",
			"PRODUCT_QUANTITY_VARIABLE" => "quantity",
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"SECTION_ID_VARIABLE" => "SECTION_ID",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_GROUPS" => "Y",
			"META_KEYWORDS" => "-",
			"META_DESCRIPTION" => "-",
			"BROWSER_TITLE" => "-",
			"ADD_SECTIONS_CHAIN" => "N",
			"DISPLAY_COMPARE" => "N",
			"SET_TITLE" => "N",
			"SET_STATUS_404" => "N",
			"CACHE_FILTER" => "N",
			"PRICE_CODE" => array("BASE"),
			"USE_PRICE_COUNT" => "N",
			"SHOW_PRICE_COUNT" => "1",
			"PRICE_VAT_INCLUDE" => "Y",
			"PRODUCT_PROPERTIES" => "",
			"USE_PRODUCT_QUANTITY" => "N",
			"DISPLAY_TOP_PAGER" => "Y",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"PAGER_TITLE" => "Товары",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => "",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			),
			false,
			array(
			"ACTIVE_COMPONENT" => "Y",
			"HIDE_ICO"=> "Y"
			)
		);?>		
			
			<div class="b_clear"></div>			
			<?echo $arResult["DETAIL_TEXT"];?>			
	</div>	