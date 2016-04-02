<?

define('NO_AGENT_CHECK',	true);
define('STOP_STATISTICS',	true);
include_once($_SERVER["DOCUMENT_ROOT"]	.	"/bitrix/modules/main/include/prolog_before.php");

\Bitrix\Main\Loader::IncludeModule("iblock");
\Bitrix\Main\Loader::IncludeModule("sale");
\Bitrix\Main\Loader::IncludeModule("catalog");

$ID	=	(int)$_REQUEST["id"];
$arBasketItems	=	array();
$dbBasketItems	=	CSaleBasket::GetList(
																array(
												"NAME"	=>	"ASC",
												"ID"	=>	"ASC"
																),	array(
												"FUSER_ID"	=>	CSaleBasket::GetBasketUserID(),
												"LID"	=>	SITE_ID,
												"ORDER_ID"	=>	"NULL",
												"ID"	=>	$ID,
																),	false,	false,	array("ID",	"CALLBACK_FUNC",	"MODULE",
												"PRODUCT_ID",	"QUANTITY",	"DELAY",
												"CAN_BUY",	"PRICE",	"WEIGHT")
);
while	($arItems	=	$dbBasketItems->Fetch())	{
		#var_dump($arItems);
}

//