<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
		die();

$page	=	$APPLICATION->GetCurPage(true);
				
$page2	=	$APPLICATION->GetCurPage();
if(preg_match("/\/(.*?)[^\/]$/i",	$page2, $arRes)){
		LocalRedirect($arRes[0]."/");	
		die();
}
if($page == "/catalog/index.php"){
		LocalRedirect("/");	
}else{
		CHTTP::SetStatus("404 Not Found");
}

