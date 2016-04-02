<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
		die();
$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>

<div class="b_pagen">
		<?if ($arResult["NavPageNomer"] > 1):?>				
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" class="b_prev"></a>
		<?else:?>
				<span class="b_prev diss"></span>
		<?	endif	?>
		
		<?if($arResult["nStartPage"] > 1):?>
				<span class="dotted">&hellip;</span>
		<?endif;?>
				
		<?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>
				<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
					<span class="active"><?=$arResult["nStartPage"]?></span>
				<?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
					<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a>
				<?else:?>
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a>
				<?endif?>
				<?$arResult["nStartPage"]++?>
		<?endwhile?>
		
		<?if($arResult["nStartPage"] < $arResult["NavPageCount"]):?>
				<span class="dotted">&hellip;</span>
		<?endif;?>
				
		<?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" class="b_next"></a>		
		<?	else:	?>
				<span class="b_next diss"></span>
		<?endif?>
</div>