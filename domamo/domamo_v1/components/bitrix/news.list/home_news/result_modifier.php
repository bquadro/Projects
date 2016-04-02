<?
CModule::IncludeModule("iblock");

//Третья новость картинкой
$arResult["NEWS_IMAGE"] = false;
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "!PREVIEW_PICTURE" => false);
$arFilter["PROPERTY"]["STATUS"] = array(5); //5 = Вывод картинкой
$res = CIBlockElement::GetList(array($arParams["SORT_BY1"]=>$arParams["SORT_ORDER1"], $arParams["SORT_BY2"]=>$arParams["SORT_ORDER2"]),  $arFilter, false, Array("nPageSize"=>1), $arSelect );
if($ob = $res->GetNextElement()) {
		$arFields = $ob->GetFields();
		$arResult["NEWS_IMAGE"] = $arFields;
}