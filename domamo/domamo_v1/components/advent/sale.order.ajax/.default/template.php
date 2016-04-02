<?
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)
		die();
if	($USER->IsAuthorized()	||	$arParams["ALLOW_AUTO_REGISTER"]	==	"Y")	{
		if	($arResult["USER_VALS"]["CONFIRM_ORDER"]	==	"Y"	||	$arResult["NEED_REDIRECT"]	==	"Y")	{
				if	(strlen($arResult["REDIRECT_URL"])	>	0)	{
						$APPLICATION->RestartBuffer();
						?>
						<script type="text/javascript">
								window.top.location.href = '<?=	CUtil::JSEscape($arResult["REDIRECT_URL"])	?>';
						</script>
						<?
						die();
				}
		}
}

error_reporting(7); ini_set('display_errors', 1);

CJSCore::Init(array('fx',	'popup',	'window',	'ajax'));
?>

<a name="order_form"></a>
<div class="tabs ordering_page_container">
  <ul class="tabs__caption no_content cf">
      <li class="">
          1   ваш Заказ
      </li>
      <li class="active">
          2   оплата и доставка
      </li>
  </ul>
<div id="order_form_div" class="order-checkout">
		<NOSCRIPT>
		<div class="errortext"><?=	GetMessage("SOA_NO_JS")	?></div>
		</NOSCRIPT>

		<?
		if	(!function_exists("getColumnName"))	{

				function	getColumnName($arHeader)	{
						return	(strlen($arHeader["name"])	>	0)	?	$arHeader["name"]	:	GetMessage("SALE_"	.	$arHeader["id"]);
				}

		}

		if	(!function_exists("cmpBySort"))	{

				function	cmpBySort($array1,	$array2)	{
						if	(!isset($array1["SORT"])	||	!isset($array2["SORT"]))
								return	-1;

						if	($array1["SORT"]	>	$array2["SORT"])
								return	1;

						if	($array1["SORT"]	<	$array2["SORT"])
								return	-1;

						if	($array1["SORT"]	==	$array2["SORT"])
								return	0;
				}

		}
		?>

		<div class="bx_order_make">
				<?
				if	(!$USER->IsAuthorized()	&&	$arParams["ALLOW_AUTO_REGISTER"]	==	"N")	{
						if	(!empty($arResult["ERROR"]))	{
								foreach	($arResult["ERROR"]	as	$v)
										echo	ShowError($v);
						}	elseif	(!empty($arResult["OK_MESSAGE"]))	{
								foreach	($arResult["OK_MESSAGE"]	as	$v)
										echo	ShowNote($v);
						}

						include($_SERVER["DOCUMENT_ROOT"]	.	$templateFolder	.	"/auth.php");
				}	else	{
						if	($arResult["USER_VALS"]["CONFIRM_ORDER"]	==	"Y"	||	$arResult["NEED_REDIRECT"]	==	"Y")	{
								if	(strlen($arResult["REDIRECT_URL"])	==	0)	{
										include($_SERVER["DOCUMENT_ROOT"]	.	$templateFolder	.	"/confirm.php");
								}
						}	else	{
								?>
								<script type="text/javascript">
										var show_error = false;
										function applyCustomForm() {
												
														$('.order-container input, .order-container select').each(function(index, elem) {
																$(elem).styler();
														});
														$('.req').each(function(index, elem) {
																if ($(elem).val().trim() == '' && show_error) {
																		$(elem).css({'background-color': '#F9D2D2'});
																} 
														})
												
										}

										BX.addCustomEvent('onAjaxSuccess', function() {
												applyCustomForm();
										});

										function submitForm(val)
										{
												show_error = true;
												if (val != 'Y') {
														BX('confirmorder').value = 'N';
														show_error = false;
												}
												console.log(BX('confirmorder').value);
												var orderForm = BX('ORDER_FORM');


												//BX.ajax.submitComponentForm(orderForm, 'order_form_content', true);

												//BX.submit(orderForm, ajaxResult);
												BX.ajax.submit(orderForm, ajaxResult);
												$.fancybox.showLoading();

												return true;
										}
										function ajaxResult(res)
										{
												var orderForm = BX('ORDER_FORM');
												$.fancybox.hideLoading();
												BX('order_form_content').innerHTML = res;
												BX.onCustomEvent(orderForm, 'onAjaxSuccess');
										}
										function SetContact(profileId)
										{
												BX("profile_change").value = "Y";
												submitForm();
										}
								</script>

										<?	if	($_POST["is_ajax_post"]	!=	"Y")	{	?>
												<form action="<?=	$APPLICATION->GetCurPage();	?>" class="order_form border_in_bottom" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
														<fieldset>
																<?=	bitrix_sessid_post()	?>
																<div id="order_form_content">
																		<?
																}	else	{
																		$APPLICATION->RestartBuffer();
																}

																global	$currentOrderStep;
																$currentOrderStep	=	0;
																?>

																<?
																include($_SERVER["DOCUMENT_ROOT"]	.	$templateFolder	.	"/props.php");
																?>


																<?
																if	($arParams["DELIVERY_TO_PAYSYSTEM"]	==	"p2d")	{
																		?>
																		<div class="step">
																				<div class="title">
																						<div class="step-label">
																								<div class="label-holder">
																										<strong><?=	++$currentOrderStep	?></strong>
																										<p><?=	GetMessage('SOA_TEMPL_SHAG')	?></p>
																								</div>
																						</div>
																						<h2><?=	GetMessage('SOA_TEMPL_PAYMENT')	?></h2>
																				</div>
																				<div class="holder">
																						<?	include($_SERVER["DOCUMENT_ROOT"]	.	$templateFolder	.	"/paysystem.php");	?>
																				</div>
																		</div>
																		<div class="step">
																				<div class="title">
																						<div class="step-label">
																								<div class="label-holder">
																										<strong><?=	++$currentOrderStep	?></strong>
																										<p><?=	GetMessage('SOA_TEMPL_SHAG')	?></p>
																								</div>
																						</div>
																						<h2><?=	GetMessage('SOA_TEMPL_DELIVER')	?></h2>
																				</div>
																				<div class="holder">
																						<?	include($_SERVER["DOCUMENT_ROOT"]	.	$templateFolder	.	"/delivery.php");	?>
																				</div>
																		</div>
																		<?
																}	else	{
																		?>
																		<h3><?=	GetMessage('SOA_TEMPL_DELIVER')	?></h3>
																		<?	include($_SERVER["DOCUMENT_ROOT"]	.	$templateFolder	.	"/delivery.php");	?>
																		<h3><?=	GetMessage('SOA_TEMPL_PAYMENT')	?></h3>
																		<?	include($_SERVER["DOCUMENT_ROOT"]	.	$templateFolder	.	"/paysystem.php");	?>
																		<?
																}
																?>
<div class="final_order_block final_order_block-pay border_in_bottom cf">
																<?
																include($_SERVER["DOCUMENT_ROOT"]	.	$templateFolder	.	"/person_type.php");
																//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php");

																include($_SERVER["DOCUMENT_ROOT"]	.	$templateFolder	.	"/summary.php");

																if	(strlen($arResult["PREPAY_ADIT_FIELDS"])	>	0)
																		echo	$arResult["PREPAY_ADIT_FIELDS"];
																?>

                                <div class="final_order_block_price cf">

                                  <div class="final_order_block_price-old">
                                      Стоимость заказа:
                                      <span><?=str_replace(' руб.','', $arResult["ORDER_PRICE_FORMATED"])?>&#8381;</span>
                                  </div>
                                  <?
                                  if (doubleval($arResult["DISCOUNT_PRICE"]) > 0)
                                  {
                                      ?>
                                      <div class="final_order_block_price-discount">
                                          <?=GetMessage("SOA_TEMPL_SUM_DISCOUNT")?><?if (strLen($arResult["DISCOUNT_PERCENT_FORMATED"])>0):?> (<?echo $arResult["DISCOUNT_PERCENT_FORMATED"];?>)<?endif;?>:
                                          <span><?=str_replace(' руб.','', $arResult["DISCOUNT_PRICE_FORMATED"])?>&#8381;</span>
                                      </div>
                                  <?
                                  }
                                  if(!empty($arResult["TAX_LIST"]))
                                  {
                                      foreach($arResult["TAX_LIST"] as $val)
                                      {
                                          ?>
                                          <div class="final_order_block_price-discount">
                                              <?=$val["NAME"]?> <?=$val["VALUE_FORMATED"]?>:
                                              <span><?=str_replace(' руб.','', $val["VALUE_MONEY_FORMATED"])?>&#8381;</span>
                                          </div>
                                      <?
                                      }
                                  }
                                  //var_dump($arResult);
                                  $delivery_method = null;
                                  foreach($arResult['DELIVERY'] as $delivery_item){
                                    if($delivery_item['CHECKED'] == 'Y'){
                                      $delivery_method = $delivery_item['ID'];
                                    }
                                  }
                                  
                                  if (doubleval($arResult["DELIVERY_PRICE"]) > 0)
                                  {
                                      ?>
                                      <div class="">
                                          <?=GetMessage("SOA_TEMPL_SUM_DELIVERY")?>
                                          <span><?=str_replace(' руб.','', $arResult["DELIVERY_PRICE_FORMATED"])?>&#8381;</span>
                                      </div>
                                  <?
                                  } else
                                  if($delivery_method != 2) {?>
                                      <div class="final_order_block_price-old">
                                          ДОСТАВКА В ПОДАРОК:
                                          <span><strike>500&#8381;</strike></span>
                                      </div>
                                 <? }
                                  if (strlen($arResult["PAYED_FROM_ACCOUNT_FORMATED"]) > 0)
                                  {
                                      ?>
                                      <div class="final_order_block_price-discount">
                                          <?=GetMessage("SOA_TEMPL_SUM_PAYED")?>
                                          <span><?=str_replace(' руб.','', $arResult["PAYED_FROM_ACCOUNT_FORMATED"])?>&#8381;</span>
                                      </div>
                                  <?
                                  }?>
              
                                      <div class="final_order_block_price-price">
                                          ИТОГОВАЯ СТОИМОСТЬ ЗАКАЗА:
                                          <span><?=str_replace(' руб.','', $arResult["ORDER_TOTAL_PRICE_FORMATED"])?>&#8381;</span>
                                      </div>
                                  
                      </div>    
                      </div>
				<div class="order_blocks_buttons cf">
                <a href="/personal/basket" class="big_gray_button"><span class="ico"></span> К заказу</a>
								<a href="javascript:void();" onclick="submitForm('Y'); return false;" class="big_blue_button"><span>Завершить оформление</span></a>
            </div>

																<?
																if	($_POST["is_ajax_post"]	!=	"Y")	{
																		?>
																</div>
																<input type="hidden" name="confirmorder" id="confirmorder" value="Y">
																<input type="hidden" name="profile_change" id="profile_change" value="N">
																<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">

														</fieldset>
												</form>
												<?
										}	else	{
												?>
												<script type="text/javascript">
														top.BX('confirmorder').value = 'Y';
														top.BX('profile_change').value = 'N';
												</script>
												<?
												die();
										}
								
						}
				}
				?>
		</div>
</div>
</div>