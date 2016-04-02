<?
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)
		die();
$this->setFrameMode(true);

if	(!empty($arResult['ITEMS']))	{
		?>				
		<div class="b_wrapper">
				<div class="horizontal-slider">
						<span class="zagolovok"><?=$arParams["TITLE_BLOCK"]?></span>
						<div class="wrap_item" id="sliderbar_project">
								<div class="wrap_item2">	<div class="wrap_item3">
		<?																												
		foreach	($arResult['ITEMS']	as	$key	=>	$arElement)	{
			 #$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
        #$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
				
				if(!$arElement["PREVIEW_PICTURE"])
						$arElement["PREVIEW_PICTURE"] = $arElement["DETAIL_PICTURE"];                
				if(!$arElement["PREVIEW_PICTURE"])
						$arElement["PREVIEW_PICTURE"] = array("src" => "/images/no_photo.png");
				else
						$arElement["PREVIEW_PICTURE"] = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"], array("width" => 277,   "height" => 193), BX_RESIZE_IMAGE_EXACT, false, array());         
					
			
				?>
				<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"  class="item <?= $key+1==count($arResult['ITEMS'])?"last":""?>">
						<div class="b_img"><img src="<?=$arElement["PREVIEW_PICTURE"]["src"]?>" alt=""></div>
						<div class="bottom">
								<div class="name"><?=$arElement["NAME"]?><span><?=count($arElement["PROPERTIES"]["CML2_LINK"]["VALUE"])?></span></div>
								<span class="open"></span>
						</div>
				</a>						
				<?
		}
		?>	</div></div></div></div></div><?
}
