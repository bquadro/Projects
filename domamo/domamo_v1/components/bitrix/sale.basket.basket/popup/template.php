<?
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)
		die();

$arUrls	=	Array(
				"delete"	=>	SITE_DIR	.	"ajax/basket.php?action=delete&id=#ID#",
				"delay"	=>	$APPLICATION->GetCurPage()	.	"?action=delay&id=#ID#",
				"add"	=>	$APPLICATION->GetCurPage()	.	"?action=add&id=#ID#",
);

include($_SERVER["DOCUMENT_ROOT"]	.	$templateFolder	.	"/functions.php");

$normalCount	=	count($arResult["ITEMS"]["AnDelCanBuy"]);
$normalHidden	=	($normalCount	==	0)	?	"style=\"display:none\""	:	"";

$delayCount	=	count($arResult["ITEMS"]["DelDelCanBuy"]);
$delayHidden	=	($delayCount	==	0)	?	"style=\"display:none\""	:	"";

$subscribeCount	=	count($arResult["ITEMS"]["ProdSubscribe"]);
$subscribeHidden	=	($subscribeCount	==	0)	?	"style=\"display:none\""	:	"";

$naCount	=	count($arResult["ITEMS"]["nAnCanBuy"]);
$naHidden	=	($naCount	==	0)	?	"style=\"display:none\""	:	"";

?>
<a class="mini-cart" href="<?=	$arParams["PATH_TO_BASKET"]	?>"><span class="desc">Моя корзина</span> <span class="number"><?=	$normalCount	?></span></a>
<?	if	($normalCount	>	0):	?>
		<div class="cart-popup">
				<?	include($_SERVER["DOCUMENT_ROOT"]	.	$templateFolder	.	"/basket_items.php");	?>
		</div>
<?endif;?>