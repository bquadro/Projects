<?
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)
		die();

use	Bitrix\Sale\DiscountCouponsManager;

if	(!empty($arResult["ERROR_MESSAGE"]))
		ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn	=	false;
$bDeleteColumn	=	false;
$bWeightColumn	=	false;
$bPropsColumn	=	false;
$bPriceType	=	false;


//Материалы
$HLB_MATERIAL	=	2;

use	Bitrix\Highloadblock	as	HL;
use	Bitrix\Main\Entity;

$hlblock	=	HL\HighloadBlockTable::getById($HLB_MATERIAL)->fetch();
$entity	=	HL\HighloadBlockTable::compileEntity($hlblock);
$main_query	=	new	Entity\Query($entity);
$main_query->setSelect(array('*'));
$result	=	$main_query->exec();
$result	=	new	CDBResult($result);

$materials	=	array();
while	($row	=	$result->Fetch())	{
		$row["ICO"]	=	CFile::GetByID($row["UF_FILE"]);
		$materials[$row["UF_XML_ID"]]	=	$row;
}

if	($normalCount	>	0):
		?>
		<script>

				$(document).ready(function () {

						$(".order_block_button, .order_block_label_title").click(function () {
								$(this).parents('.order_block').toggleClass('order_block-open');
								$(this).toggleClass('order_block_button-open');
								return false;
						});
						$(".ordering_table_row").click(function () {
								$(this).toggleClass('ordering_table_row-checked');
								return false;
						});
				});

		</script>
		<div id="basket_items_list">

				<?
				$ik	=	0;
				foreach	($arResult["GRID"]["ROWS"]	as	$k	=>	$arItem):
						$ik++;
						if	($arItem["DELAY"]	==	"N"	&&	$arItem["CAN_BUY"]	==	"Y"):

								$PROPERTY_MATERIAL_VALUES	=	explode(',',	$arItem['PROPERTY_MATERIAL_VALUE']);
								$PROPERTY_MATERIAL_VALUES	=	array_map('trim',	$PROPERTY_MATERIAL_VALUES);
								$PROPERTY_MATERIAL_VALUES	=	array_filter($PROPERTY_MATERIAL_VALUES);
								foreach	($PROPERTY_MATERIAL_VALUES	as	$PROPERTY_MATERIAL_VALUE)	{
										$arItem['MATERIAL'][]	=	$materials[$PROPERTY_MATERIAL_VALUE]['UF_NAME'];
								}
								//var_dump($arItem);
								$ico	=	$arItem['PROPERTY_OTYPE_VALUE']	==	'Гараж'	?	'garage'	:	'house';
								$ico_text	=	$arItem['PROPERTY_OTYPE_VALUE']	?	$arItem['PROPERTY_OTYPE_VALUE']	:	'Дом';
								?>
								<div id="<?=	$arItem["ID"]	?>" class="order_block cf <?php	print	($ik)	==	count($arResult["GRID"]["ROWS"])	?	'last'	:	''		?>">
										<div class="order_block_label_container cf">
												<a href="#" class="order_block_label order_block_label_title">
														<span class="ico_<?=	$ico;	?> ico"></span>
														<?=	$ico_text;	?>
														<span class="label_hover"></span>
												</a>
												<a href="<?=	str_replace("#ID#",	$arItem["ID"],	$arUrls["delete"])	?>" class="order_block_label order_block_label_del"><span class="ico"></span>Удалить проект</a>
										</div>
										<div class="order_block_main_info cf">

												<div class="project_photo">
														<?
														if	(isset($arItem["PREVIEW_PICTURE"])	&&	intval($arItem["PREVIEW_PICTURE"])	>	0):
																$arImage	=	CFile::GetFileArray($arItem["PREVIEW_PICTURE"]);
																if	($arImage):
																		$arFileTmp	=	CFile::ResizeImageGet(
																																		$arImage,	array("width"	=>	"278",	"height"	=>	"278"),	BX_RESIZE_IMAGE_PROPORTIONAL,	true
																		);
																		$url	=	$arFileTmp["src"];
																endif;
														else:
																$url	=	$templateFolder	.	"/images/no_photo.png";
														endif;
														?>

														<?	if	(strlen($arItem["DETAIL_PAGE_URL"])	>	0):	?><a href="<?=	$arItem["DETAIL_PAGE_URL"]	?>"><?	endif;	?>
																<img class="bx_ordercart_photo" src="<?=	$url	?>"/>
																<?	if	(strlen($arItem["DETAIL_PAGE_URL"])	>	0):	?></a><?	endif;	?>

														<div class="project_short_info cf">
																<div class="project_name"><?=	$arItem["PROPERTY_CODE_VALUE"];	?></div>
																<div class="project_square"><?=	$arItem["PROPERTY_AREA1_VALUE"];	?> m2</div>
														</div>
												</div>

												<div class="project_main_info_block cf">
														<div class="project_char">
																<?	if	(strlen($arItem["DETAIL_PAGE_URL"])	>	0):	?><a href="<?=	$arItem["DETAIL_PAGE_URL"]	?>" class="project_title"><?	endif;	?>
																<?=	strtoupper($arItem["PROPERTY_CODE_VALUE"])	?> <?=	$arItem["NAME"]	?>
																		<?	if	(strlen($arItem["DETAIL_PAGE_URL"])	>	0):	?></a><?	endif;	?>
																<h4>Технические характеристики: </h4>
																<table>
																		<tbody><tr>
																						<td>Материал стен:</td>
																						<td><?=	implode(', ',	$arItem['MATERIAL']);	?></td>
																				</tr>
																				<tr>
																						<td>Общая площадь:</td>
																						<td><?=	$arItem["PROPERTY_AREA1_VALUE"];	?> m2</td>
																				</tr>
																				<tr>
																						<td>Жилая площадь:</td>
																						<td><?=	$arItem["PROPERTY_AREA3_VALUE"];	?> m2</td>
																				</tr>
																				<tr>
																						<td>Гараж:</td>
																						<td><?=	$arItem["PROPERTY_GARAGE_VALUE"];	?></td>
																				</tr>
																				<tr>
																						<td>Этажи:</td>
																						<td><?=	$arItem["PROPERTY_FLOORS_VALUE"];	?></td>
																				</tr>
																		</tbody></table>
														</div>
														<div class="project_price">
																<?=	catalog_price_format($arItem["PRICE"])	?>
														</div>
												</div>

										</div>
										<div class="order_block_spoiler_info" style="display: none;">

												<?	if	($arItem['~PROPERTY_BIG_TEXT_VALUE']['TEXT']	||	($arItem["OPTIONS"][0])):	?>

														<div class="order_block_added_content">
																<div class="right-side">
																		<h2>В указанную стоимость входит:</h2>
																		<div class="custom_ul">
																				<div>
																						<?=	$arItem['~PROPERTY_BIG_TEXT_VALUE']['TEXT']	?>
																						<?
																						if	($arItem["OPTIONS"][0]	&&	$USER->IsAdmin())	{
																								echo	"<br><br><b>Опции:</b><ul>";
																								foreach	($arItem["OPTIONS"][0]	as	$option)	{
																										echo	"<li>"	.	$option["NAME"]	.	"</li>";
																								}
																								echo	"</ul>";
																						}
																						?>
																				</div>
																		</div>
																</div>
														</div>
												<?	endif;	?>
												<?	if	($USER->IsAdmin()):	?>
														<div class="order_block_add_incard no_select">
																<table>
																		<tbody>
																				<?	if	($arItem["OPTIONS"][1]):	?>
																						<tr class="tr_title">
																								<td colspan="4" class="td_title">Дополнения к проекту:</td>
																								<td></td>
																								<td></td>
																						</tr>
																						<tr>
																								<th></th>
																								<th>&nbsp;</th>
																								<th>Сроки, дней</th>
																								<th>Старая цена, руб.</th>
																								<th>Итог, руб.</th>
																								<th></th>
																						</tr>
																						<?	foreach	($arItem["OPTIONS"][1]	as	$option):	?>
																								<tr class="first_row ordering_table_row">
																										<td class="td_check">
																												<div class="chechbox_container">
																														<input type="checkbox" class="checkbox" id="checkbox2">
																														<label for="checkbox2" class="td_label"></label>
																												</div>
																										</td>
																										<td class="td_name"><?=	$option["NAME"]	?> <?	if	($option["DESCRIPTION"]	!=	""):	?><a href="#" class="td_info q" data-text="<?=	show_qtip($option["DESCRIPTION"], $option["DESCRIPTION_TYPE"])	?>"></a><?	endif;	?></td>
																										<td class="td_deliver"><?=	$option["DEADLINE"]	?></td>
																										<td class="td_old_price"></td>
																										<td class="td_price"><?=	catalog_price_format($option["PRICE"])	?></td>
																										<td class="td_del">
																												<a href="#" class="del_item"></a>
																										</td>
																								</tr>
																						<?	endforeach;	?>
																				<?	endif;	?>
																				<?	if	($arItem["OPTIONS"][2]):	?>
																						<tr>
																								<td colspan="4" class="td_title">Для вас могут быть разработаны:</td>
																								<td class="td_price"></td>
																								<td></td>
																						</tr>
																						<?	foreach	($arItem["OPTIONS"][2]	as	$option):	?>
																								<tr class="first_row ordering_table_row">
																										<td class="td_check">
																												<div class="chechbox_container">
																														<input type="checkbox" class="checkbox" id="checkbox2">
																														<label for="checkbox2" class="td_label"></label>
																												</div>
																										</td>
																										<td class="td_name"><?=	$option["NAME"]	?> <?	if	($option["DESCRIPTION"]	!=	""):	?><a href="#" class="td_info q" data-text="<?=	show_qtip($option["DESCRIPTION"])	?>"></a><?	endif;	?></td>
																										<td class="td_deliver"><?=	$option["DEADLINE"]	?></td>
																										<td class="td_old_price"></td>
																										<td class="td_price"><?=	catalog_price_format($option["PRICE"])	?></td>
																										<td class="td_del">
																												<a href="#" class="del_item"></a>
																										</td>
																								</tr>
																						<?	endforeach;	?>																				
																				<?	endif;	?>
<!--																				<tr class="tr_price">
																						<td></td>
																						<td>&nbsp;</td>
																						<td>&nbsp;</td>
																						<td class="td_discount_nane">Скидка:</td>
																						<td class="td_discount_value">6 700 <span class="rubl">c</span></td>
																						<td></td>
																				</tr>-->
																				<tr class="tr_price">
																						<td></td>
																						<td>&nbsp;</td>
																						<td>&nbsp;</td>
																						<td class="td_price_nane">итог:</td>
																						<td class="td_price_value">223 000 <span class="rubl">c</span></td>
																						<td></td>
																				</tr>
																		</tbody>
																</table>
														</div>
														<?
												endif;
												?>
										</div>

										<div class="order_block_button roll_up_block">развернуть проект <span></span></div>
										<div class="order_block_button cut_down_block">СВЕРНУТЬ проект <span></span></div>
								</div>
								<?
						endif;
				endforeach;
				?>

				<input type="hidden" id="column_headers" value="<?=	CUtil::JSEscape(implode($arHeaders,	","))	?>" />
				<input type="hidden" id="offers_props" value="<?=	CUtil::JSEscape(implode($arParams["OFFERS_PROPS"],	","))	?>" />
				<input type="hidden" id="action_var" value="<?=	CUtil::JSEscape($arParams["ACTION_VARIABLE"])	?>" />
				<input type="hidden" id="quantity_float" value="<?=	$arParams["QUANTITY_FLOAT"]	?>" />
				<input type="hidden" id="count_discount_4_all_quantity" value="<?=	($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"]	==	"Y")	?	"Y"	:	"N"	?>" />
				<input type="hidden" id="price_vat_show_value" value="<?=	($arParams["PRICE_VAT_SHOW_VALUE"]	==	"Y")	?	"Y"	:	"N"	?>" />
				<input type="hidden" id="hide_coupon" value="<?=	($arParams["HIDE_COUPON"]	==	"Y")	?	"Y"	:	"N"	?>" />
				<input type="hidden" id="use_prepayment" value="<?=	($arParams["USE_PREPAYMENT"]	==	"Y")	?	"Y"	:	"N"	?>" />

				<div class="final_order_block">
						<div class="cf">
								<div class="final_order_block_names">
										<?php
										foreach	($arResult["GRID"]["ROWS"]	as	$k	=>	$arItem):
												if	($arItem["DELAY"]	==	"N"	&&	$arItem["CAN_BUY"]	==	"Y"):
														$ico	=	$arItem['PROPERTY_OTYPE_VALUE']	==	'Гараж'	?	'garage'	:	'house';
														?>
														<div class="final_order_block_item cf">
																<span class="short_project_name"><span class="ico ico_<?=	$ico;	?>"></span><?=	strtoupper($arItem["PROPERTY_CODE_VALUE"])	?></span>
																<span class="full_project_name"><?=	$arItem["NAME"]	?></span>
														</div><?
												endif;
										endforeach;
										?>

								</div>
								<div class="final_order_block_price">
										<?	if	(floatval($arResult["DISCOUNT_PRICE_ALL"])	>	0):	?>
												<div class="final_order_block_price-old">
														стоимость заказа:
														<span><strike id="PRICE_WITHOUT_DISCOUNT"><?=	str_replace(' руб.',	'',	$arResult["PRICE_WITHOUT_DISCOUNT"])	?>&#8381;</strike></span>
												</div>
										<?	endif;	?>
										<?php	if	(floatval($arResult["DISCOUNT_PRICE_ALL"])	>	0):	?>
												<div class="final_order_block_price-discount">
														ваша экономия:
														<span id="DISCOUNT_PRICE_ALL_FORMATED"><?=	str_replace(' руб.',	'',	$arResult["DISCOUNT_PRICE_ALL_FORMATED"])	?>&#8381;</span>
												</div>
										<?php	endif;	?>
										<div class="final_order_block_price-price">
												итоговая стоимость заказа:
												<span id="allSum_FORMATED"><?=	str_replace(' руб.',	'',	$arResult["allSum_FORMATED"])	?>&#8381;</span>
										</div>
								</div>
						</div>
						<div class="order_blocks_buttons cf">
								<a href="javascript:void(0)" onclick="checkOut();" class="big_blue_button"><?=	GetMessage("SALE_ORDER")	?></a>

						</div>
				</div>

				<div class="bx_ordercart_order_pay">

						<div class="bx_ordercart_order_pay_left" id="coupons_block">
								<?
								if	($arParams["HIDE_COUPON"]	!=	"Y")	{
										?>
										<div class="bx_ordercart_coupon">
												<span><?=	GetMessage("STB_COUPON_PROMT")	?></span><input type="text" id="coupon" name="COUPON" value="" onchange="enterCoupon();">
										</div><?
										if	(!empty($arResult['COUPON_LIST']))	{
												foreach	($arResult['COUPON_LIST']	as	$oneCoupon)	{
														$couponClass	=	'disabled';
														switch	($oneCoupon['STATUS'])	{
																case	DiscountCouponsManager::STATUS_NOT_FOUND:
																case	DiscountCouponsManager::STATUS_FREEZE:
																		$couponClass	=	'bad';
																		break;
																case	DiscountCouponsManager::STATUS_APPLYED:
																		$couponClass	=	'good';
																		break;
														}
														?><div class="bx_ordercart_coupon"><input disabled readonly type="text" name="OLD_COUPON[]" value="<?=	htmlspecialcharsbx($oneCoupon['COUPON']);	?>" class="<?	echo	$couponClass;	?>"><span class="<?	echo	$couponClass;	?>" data-coupon="<?	echo	htmlspecialcharsbx($oneCoupon['COUPON']);	?>"></span><div class="bx_ordercart_coupon_notes"><?
														if	(isset($oneCoupon['CHECK_CODE_TEXT']))	{
																echo	(is_array($oneCoupon['CHECK_CODE_TEXT'])	?	implode('<br>',	$oneCoupon['CHECK_CODE_TEXT'])	:	$oneCoupon['CHECK_CODE_TEXT']);
														}
														?></div></div><?
												}
												unset($couponClass,	$oneCoupon);
										}
								}	else	{
										?><?
								}
								?>

						</div>


				</div>
		</div>
		<?
else:
		?>
		<div id="basket_items_list">
				<table>
						<tbody>
								<tr>
										<td colspan="<?=	$numCells	?>" style="text-align:center">
												<div class=""><?=	GetMessage("SALE_NO_ITEMS");	?></div>
										</td>
								</tr>
						</tbody>
				</table>
		</div>
<?
endif;
?>