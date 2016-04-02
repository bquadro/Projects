<?
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)
		die();
$this->setFrameMode(true);

if	(!empty($arResult['ITEMS']))	{
		$arResult['SHOW_NAME'] = "Y";
		?><div class="projects"><div class="wrap_item"><div class="wrap_item2"><?	
								
		include	$_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/components/cataog_card_mini.tpl.php';		
		?></div></div></div><?
		if	($arParams["DISPLAY_BOTTOM_PAGER"]):
				?>
				<div class="b_bot_pagen"><?=($arResult["NAV_STRING"]);?></div>
				<div class="clear"></div>
				<?
		endif;
}
