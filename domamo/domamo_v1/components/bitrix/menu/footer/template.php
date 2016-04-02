<?	
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)	die();		

if	(!empty($arResult)):	
		
		$cnt = (int)$arParams["BLOCK_COUNT"];
		if($cnt < 1)
				$cnt = 1;
		
		$row_cnt = ceil(count($arResult)/$cnt);
		//var_dump(count($arResult), $row_cnt);
		$k = 0;
		$r = 1;
		?><div class="b_title"><?=$arParams["BLOCK_NAME"]?></div><?
		if($cnt > 1):
				?><div class="block block1"><?
		endif;
		foreach	($arResult	as	$arItem):

				if($arItem["LINK"] == ""):
						?><div><?=	$arItem["TEXT"]	?></div><?
				elseif( $arItem["LINK"] == $APPLICATION->GetCurPage() ):
						echo hideJS('<a href="'.$arItem["LINK"]	.'" class="active">'.$arItem["TEXT"].'</a>');				
				elseif($arItem["SELECTED"]):
						?><a href="<?=	$arItem["LINK"]	?>" class="active"><?=	$arItem["TEXT"]	?></a><?
				else:
						?><a href="<?=	$arItem["LINK"]	?>"><?=	$arItem["TEXT"]	?></a><?
				endif;
				
				$k++;
				if($k%$row_cnt == 0 && $k!=count($arResult) && $cnt>1){
						$r++;
						echo "</div><div class='block block{$r}'>";
				}								
		endforeach;		
		if($cnt>1):
				?></div><?
		endif;
		?>
		<div class="clear"></div>
		<?
endif
?>