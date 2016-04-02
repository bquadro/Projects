<?
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)
		die();

use Bitrix\Main\Loader;
if	(!Loader::includeModule("iblock"))
		return;

$arProperty	=	array();
if	(0	<	intval($arCurrentValues["IBLOCK_ID"]))	{
		$rsProp	=	CIBlockProperty::GetList(array("sort"	=>	"asc",	"name"	=>	"asc"),	array("IBLOCK_ID"	=>	$arCurrentValues["IBLOCK_ID"],	"ACTIVE"	=>	"Y"));
		while	($arr	=	$rsProp->Fetch())	{
				if	($arr["PROPERTY_TYPE"]	!=	"F")
						$arProperty[$arr["CODE"]]	=	"["	.	$arr["CODE"]	.	"] "	.	$arr["NAME"];
		}
}

$arTemplateParameters["DETAIL_PROPERTY_TECH_1"]	=	array(
				"PARENT"	=>	"DETAIL_SETTINGS",
				"NAME"	=>	"Характеристики общие",
				"TYPE"	=>	"LIST",
				"MULTIPLE"	=>	"Y",
				"ADDITIONAL_VALUES"	=>	"Y",
				"SIZE" => 8,
				"VALUES"	=>	$arProperty,
);
$arTemplateParameters["DETAIL_PROPERTY_TECH_2"]	=	array(
				"PARENT"	=>	"DETAIL_SETTINGS",
				"NAME"	=>	"Характеристики дополнительные",
				"TYPE"	=>	"LIST",
				"MULTIPLE"	=>	"Y",
				"ADDITIONAL_VALUES"	=>	"Y",
				"SIZE" => 8,
				"VALUES"	=>	$arProperty,
);
