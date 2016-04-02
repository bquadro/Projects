<?	if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)	die();	?>
<?
$bDefaultColumns	=	$arResult["GRID"]["DEFAULT_COLUMNS"];
$colspan	=	($bDefaultColumns)	?	count($arResult["GRID"]["HEADERS"])	:	count($arResult["GRID"]["HEADERS"])	-	1;
$bPropsColumn	=	false;
$bUseDiscount	=	false;
$bPriceType	=	false;
$bShowNameWithPicture	=	($bDefaultColumns)	?	true	:	false;	// flat to show name and picture column in one column
?>


<div class="final_order_block_names">
		<?
		foreach	($arResult["GRID"]["ROWS"]	as	$k	=>	$arData):

				$arItem	=	$arData["data"];
				if	($arItem["DELAY"]	==	"N"	&&	$arItem["CAN_BUY"]	==	"Y"	&&	$arItem["MODULE"]	==	"catalog"):
						$ico	=	$arItem	?	'house'	:	'garage';
						?>
						<div class="final_order_block_item cf">
								<span class="short_project_name"><span class="ico ico_<?=	$ico;	?>"></span><?=	strtoupper($arItem["PROPERTY_CODE_VALUE"])	?></span>
								<span class="full_project_name">
										<?
										echo $arItem["NAME"];										
										foreach	($arData["OPTIONS"][1]	as	$option):
												if	($option["IN_BASKET"]	!=	"Y")
														continue;
												?><small>, <?echo	$option["NAME"]	;?></small><?
										endforeach;
										foreach	($arData["OPTIONS"][2]	as	$option):
												if	($option["IN_BASKET"]	!=	"Y")
														continue;

												?><small>, <?echo	$option["NAME"]	;?></small><?
										endforeach;
										?>										
								</span>
						</div>
						<?
				endif;
		endforeach;
		?>

</div>