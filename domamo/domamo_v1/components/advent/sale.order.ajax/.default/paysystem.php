<?	if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)	die();	?>
<?
if((int)$arResult["USER_VALS"]["DELIVERY_LOCATION"] > 0):

?>
<script type="text/javascript">
		function submitForm123(param)
		{
				if (BX("account_only") && BX("account_only").value == 'Y') // PAY_CURRENT_ACCOUNT checkbox should act as radio
				{
						if (param == 'account')
						{
								if (BX("PAY_CURRENT_ACCOUNT"))
								{
										BX("PAY_CURRENT_ACCOUNT").checked = true;
										BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
										BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');

										// deselect all other
										var el = document.getElementsByName("PAY_SYSTEM_ID");
										for (var i = 0; i < el.length; i++)
												el[i].checked = false;
								}
						}
						else
						{
								BX("PAY_CURRENT_ACCOUNT").checked = false;
								BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
								BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
						}
				}
				else if (BX("account_only") && BX("account_only").value == 'N')
				{
						if (param == 'account')
						{
								if (BX("PAY_CURRENT_ACCOUNT"))
								{
										BX("PAY_CURRENT_ACCOUNT").checked = !BX("PAY_CURRENT_ACCOUNT").checked;

										if (BX("PAY_CURRENT_ACCOUNT").checked)
										{
												BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
												BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
										}
										else
										{
												BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
												BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
										}
								}
						}
				}

				submitForm();
		}
</script>
<div class="pay-method pay_var_container border_in_bottom cf">
		<?

		foreach	($arResult["PAY_SYSTEM"]	as	$arPaySystem)	{
				if	(strlen(trim(str_replace("<br />",	"",	$arPaySystem["DESCRIPTION"])))	>	0	||	intval($arPaySystem["PRICE"])	>	0)	{						
						?>
						<a class="item selection_unit <?	if	($arPaySystem["CHECKED"]	==	"Y")	echo	"active";	?>" href="javascript:void(0)" onclick="BX('ID_PAY_SYSTEM_ID_<?=	$arPaySystem["ID"]	?>').checked = true; submitForm();">
						<span class="ico ico_payment_<?=	$arPaySystem["ID"]	?>"></span>
								<input type="radio"
															id="ID_PAY_SYSTEM_ID_<?=	$arPaySystem["ID"]	?>"
															name="PAY_SYSTEM_ID"
															class="hidden"
															style="position: absolute; left: -9999px;display:none;"
															value="<?=	$arPaySystem["ID"]	?>"
				<?	if	($arPaySystem["CHECKED"]	==	"Y"	&&	!($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"]	==	"Y"	&&	$arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]	==	"Y"))	echo	" checked=\"checked\"";	?>
															onclick="submitForm();" />


										<?	if	($arParams["SHOW_PAYMENT_SERVICES_NAMES"]	!=	"N"):	?>                                
										<div class="selection_unit-title"><?=	$arPaySystem["PSA_NAME"];	?></div>
										<div class="selection_unit-text">
										<?
										if	(intval($arPaySystem["PRICE"])	>	0)
												echo	str_replace("#PAYSYSTEM_PRICE#",	SaleFormatCurrency(roundEx($arPaySystem["PRICE"],	SALE_VALUE_PRECISION),	$arResult["BASE_LANG_CURRENCY"]),	GetMessage("SOA_TEMPL_PAYSYSTEM_PRICE"));
										else
												echo	$arPaySystem["DESCRIPTION"];
										?>
										</div>
										<?	endif;	?>    <?
																	if	(count($arPaySystem["PSA_LOGOTIP"])	>	0):
																			print '<div class="selection_unit-img"><img src="'.$arPaySystem["PSA_LOGOTIP"]["SRC"].'" /></div>';

																	endif;
																	?>
										                        
						</a>
								<?
						}

						if	(strlen(trim(str_replace("<br />",	"",	$arPaySystem["DESCRIPTION"])))	==	0	&&	intval($arPaySystem["PRICE"])	==	0)	{
								if	(count($arResult["PAY_SYSTEM"])	==	1)	{
										?>
								<a class="item selection_unit <?	if	($arPaySystem["CHECKED"]	==	"Y"	&&	!($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"]	==	"Y"	&&	$arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]	==	"Y"))	echo	"active";	?>" href="javascript:void(0)" onclick="BX('ID_PAY_SYSTEM_ID_<?=	$arPaySystem["ID"]	?>').checked = true;
												submitForm();">
										<input type="hidden" name="PAY_SYSTEM_ID" value="<?=	$arPaySystem["ID"]	?>">
                    <span class="ico ico_payment_<?=	$arPaySystem["ID"]	?>"></span>
										<input type="radio"
																	id="ID_PAY_SYSTEM_ID_<?=	$arPaySystem["ID"]	?>"
																	name="PAY_SYSTEM_ID"
																	class="hidden"
                                  style="position: absolute; left: -9999px;display:none;"
																	value="<?=	$arPaySystem["ID"]	?>"
						<?	if	($arPaySystem["CHECKED"]	==	"Y"	&&	!($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"]	==	"Y"	&&	$arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]	==	"Y"))	echo	" checked=\"checked\"";	?>
																	onclick="submitForm();"
																	/>
										
																
										
												<?	if	($arParams["SHOW_PAYMENT_SERVICES_NAMES"]	!=	"N"):	?>
												<div class="selection_unit-title"><?=	$arPaySystem["PSA_NAME"];	?></div>
                        <?	endif;	?>	<?
																	if	(count($arPaySystem["PSA_LOGOTIP"])	>	0):
																			print '<div class="selection_unit-img"><img src="'.$arPaySystem["PSA_LOGOTIP"]["SRC"].'" /></div>';

																	endif;
																	?>


												<?	/*
													 <label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" >
													 <?
													 if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
													 $imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
													 else:
													 $imgUrl = $templateFolder."/images/logo-default-ps.gif";
													 endif;
													 ?>
													 <div class="bx_logotype">
													 <span style='background-image:url(<?=$imgUrl?>);'></span>
													 </div>
													 <?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
													 <div class="bx_description">
													 <div class="clear"></div>
													 <strong><?=$arPaySystem["PSA_NAME"];?></strong>
													 </div>
													 <?endif;?>
													*/	?>
								</a>
										<?
								}
								else	{	// more than one
										?>
								<a class="item selection_unit <?	if	($arPaySystem["CHECKED"]	==	"Y"	&&	!($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"]	==	"Y"	&&	$arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]	==	"Y"))	echo	"active";	?>" href="javascript:void(0)" onclick="BX('ID_PAY_SYSTEM_ID_<?=	$arPaySystem["ID"]	?>').checked = true;
												submitForm();">
						<span class="ico ico_payment_<?=	$arPaySystem["ID"]	?>"></span>
										<input type="radio"
																	id="ID_PAY_SYSTEM_ID_<?=	$arPaySystem["ID"]	?>"
																	name="PAY_SYSTEM_ID"
																	class="hidden"
                                  style="position: absolute; left: -9999px;display:none;"
																	value="<?=	$arPaySystem["ID"]	?>"
						<?	if	($arPaySystem["CHECKED"]	==	"Y"	&&	!($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"]	==	"Y"	&&	$arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]	==	"Y"))	echo	" checked=\"checked\"";	?>
																	onclick="submitForm();" />


												<?	if	($arParams["SHOW_PAYMENT_SERVICES_NAMES"]	!=	"N"):	?>
												<div class="selection_unit-title"><?=	$arPaySystem["PSA_NAME"];	?></div>
                        <?	endif;	?>	<?
																	if	(count($arPaySystem["PSA_LOGOTIP"])	>	0):
																			print '<div class="selection_unit-img"><img src="'.$arPaySystem["PSA_LOGOTIP"]["SRC"].'" /></div>';

																	endif;
																	?>
												<?	/*
													 <label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;submitForm();">
													 <?
													 if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
													 $imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
													 else:
													 $imgUrl = $templateFolder."/images/logo-default-ps.gif";
													 endif;
													 ?>
													 <div class="bx_logotype">
													 <span style='background-image:url(<?=$imgUrl?>);'></span>
													 </div>
													 <?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
													 <div class="bx_description">
													 <div class="clear"></div>
													 <strong>
													 <?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
													 <?=$arPaySystem["PSA_NAME"];?>
													 <?else:?>
													 <?="&nbsp;"?>
													 <?endif;?>
													 </strong>
													 </div>
													 <?endif;?>
													 </label>
													*/	?>
								</a>
										<?
								}
						}
				}
				?>
</div>
<?else:
		/*182*/
		?>
		
		<p>Требуется выбрать страну, регион и город</p>
<? endif; ?>
