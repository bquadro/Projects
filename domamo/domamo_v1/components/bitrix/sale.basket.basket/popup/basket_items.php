<?
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)
		die();
echo	ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn	=	false;
$bDeleteColumn	=	false;
$bWeightColumn	=	false;
$bPropsColumn	=	false;

if	($normalCount	>	0):
		?>
		<table class="minicart-table">
				<?
				$i	=	0;
				foreach	($arResult["GRID"]["ROWS"]	as	$k	=>	$arItem):
						////if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):

						$i++;
						if	($i	<	5):
								?>
								<tr id="<?=	$arItem["ID"]	?>">
										<?
										if	(strlen($arItem["PREVIEW_PICTURE_SRC"])	>	0):
												$url	=	$arItem["PREVIEW_PICTURE_SRC"];
										elseif	(strlen($arItem["DETAIL_PICTURE_SRC"])	>	0):
												$url	=	$arItem["DETAIL_PICTURE_SRC"];
										elseif	(!empty($arItem["~PROPERTY_MORE_PHOTO_VALUE"])):
												$url	=	CFile::GetPath(reset(explode(",",	$arItem["~PROPERTY_MORE_PHOTO_VALUE"])));
										else:
												$url	=	$templateFolder	.	"/images/no_photo.png";
										endif;
										?>
										<td class="item">												
												<a href="<?=	$arItem["DETAIL_PAGE_URL"]	?>">
														<img class="image" src="<?=	$url	?>" alt="<?=	$arItem["NAME"]	?>" width="110" />
												</a>
										</td>
										<td class="item">
												<a href="<?=	$arItem["DETAIL_PAGE_URL"]	?>">
														<div class="proj-title">
																<span><?=	$arItem['CATALOG']['PROPERTIES']['CODE']['VALUE']	.	'</span> '	.	$arItem["NAME"]	?>
														</div>
												</a>
										</td>
										<td>
												<span class="price"><?=	str_replace(' руб.',	'',	$arItem["PRICE_FORMATED"])	?>&#8381;</span>
										</td>
										<td>
												<a class="btn-remove remove-basket-btn" href="<?=	str_replace("#ID#",	$arItem["ID"],	$arUrls["delete"])	?>"><?=	GetMessage("SALE_DELETE")	?></a>
										</td>
								</tr>

								<?
								$opt_price	=	0;
								foreach	($arItem["OPTIONS"][1]	as	$option):
										if	($option["IN_BASKET"]	!=	"Y")
												continue;
										$opt_price	+=	$option["PRICE"];
										?>
										<tr>
												<td></td>
												<td class="dop_options"><?	echo	$option["NAME"];	?></td>
												<td class="dop_options"><?	echo	catalog_price_format($option["PRICE"]);	?></td>
												<td></td>
										</tr>
										<?
								endforeach;
								foreach	($arItem["OPTIONS"][2]	as	$option):
										if	($option["IN_BASKET"]	!=	"Y")
												continue;
										$opt_price	+=	$option["PRICE"];
										?>
										<tr>
												<td></td>
												<td class="dop_options"><?	echo	$option["NAME"];	?></td>
												<td class="dop_options"><?	echo	catalog_price_format($option["PRICE"]);	?></td>
												<td></td>
										</tr>
										<?
								endforeach;
								?>
								<tr class="hr"><td colspan="4"></td></tr>					
						<?
				//endwhile;
				endif;
		endforeach;
		?>

		</table>
		<?	if	(count($arResult['ITEMS']['AnDelCanBuy'])	>	5):
				?>
				<div class="cart-message">
						<p><?=	GetMessage('SALE_YET')	?> <?=	sklonen(count($arResult["ITEMS"]["AnDelCanBuy"])	-	5,	GetMessage('SALE_TOVAR_1'),	GetMessage('SALE_TOVAR_2'),	GetMessage('SALE_TOVAR_3'))	?>. <a href="<?=	$arParams["PATH_TO_BASKET"]	?>"><?=	GetMessage('SALE_BASKET')	?></a></p>
				</div>
		<?	endif;	?>
		<div class="bottom-box">		
				<div class="total">
						<p><?=	GetMessage("SALE_TOTAL")	?><p>
								<strong><?=	$arResult["allSum_FORMATED"];	?></strong>
				</div>
				<a class="button big_blue_button" href="<?=	$arParams["PATH_TO_ORDER"]	?>"><?=	GetMessage("SALE_ORDER")	?></a>
		</div>
		<?
endif;
?>