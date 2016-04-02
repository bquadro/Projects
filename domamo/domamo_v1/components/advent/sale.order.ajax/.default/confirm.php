<?	if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)	die();	?>
<?
global	$APPLICATION;
if	(!empty($arResult["ORDER"]))	{
		?>
		<div class="success-order">
				<div class="success-message">
						<div class="holder">
								<span class="corner">&nbsp;</span>
								<div class="title">
										<h3><?=	GetMessage("SOA_TEMPL_ORDER_SUC",	Array("#ORDER_DATE#"	=>	$arResult["ORDER"]["DATE_INSERT"],	"#ORDER_ID#"	=>	$arResult["ORDER"]["ID"]))	?></h3>
								</div>
								<p><?=	GetMessage("SOA_TEMPL_ORDER_SUC1",	Array("#LINK#"	=>	$arParams["PATH_TO_PERSONAL"]))	?></p>

		<?
		if	(!empty($arResult["PAY_SYSTEM"]))	{
				?>
										<div class="wallet">
												<div class="img">
														<div class="a-middle">
				<?=	CFile::ShowImage($arResult["PAY_SYSTEM"]["LOGOTIP"],	150,	42,	"border=0",	"",	false);	?>
														</div>
												</div>

												<div>
														<h4><?=	GetMessage("SOA_TEMPL_PAY")	?>: <?=	$arResult["PAY_SYSTEM"]["NAME"]	?></h4>
														<p>
				<?
				if	(strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"])	>	0)	{
						if	($arResult["PAY_SYSTEM"]["NEW_WINDOW"]	==	"Y")	{
								?>
																				<script language="JavaScript">
																						window.open('<?=	$arParams["PATH_TO_PAYMENT"]	?>?ORDER_ID=<?=	urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))	?>');</script>
																						<?=	GetMessage("SOA_TEMPL_PAY_LINK",	Array("#LINK#"	=>	$arParams["PATH_TO_PAYMENT"]	.	"?ORDER_ID="	.	urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))))	?>
																						<?
																				if	(CSalePdf::isPdfAvailable()	&&	CSalePaySystemsHelper::isPSActionAffordPdf($arResult['PAY_SYSTEM']['ACTION_FILE']))	{
																						?><br />
																						<?=	GetMessage("SOA_TEMPL_PAY_PDF",	Array("#LINK#"	=>	$arParams["PATH_TO_PAYMENT"]	.	"?ORDER_ID="	.	urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))	.	"&pdf=1&DOWNLOAD=Y"))	?>
																								<?
																						}
																				}	else	{
																						if	(strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])	>	0)	{

																								include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
																						}
																				}
																		}
																		?>
														</p>
												</div>
										</div>
				<?
		}
		?>
						</div>
				</div>
		</div>
		<?
		CModule::IncludeModule("sale");
		CModule::IncludeModule("iblock");
		CModule::IncludeModule("catalog");
		$productID	=	$sectionID	=	false;
		$order_was_viewed	=	$APPLICATION->get_cookie("ORDER_WATCH_ID_"	.	$arResult["ORDER"]["ID"]);
		if	(!$order_was_viewed)	
		{		
				$APPLICATION->set_cookie("ORDER_WATCH_ID_"	.	$arResult["ORDER"]["ID"],	1);
				$dbBasketItems	=	CSaleBasket::GetList(array(),	array("ORDER_ID"	=>	$arResult["ORDER"]["ID"]));
				while	($arItems	=	$dbBasketItems->Fetch())	{
						$arItem[]	=	$arItems;
						$productID[]	=	$arItems["PRODUCT_ID"];
				}
				if	($productID)	{
						$arFilter	=	array("IBLOCK_ID"	=>	2,	"ID"	=>	$productID);
						$productID	=	false;
						$rsSect	=	CIBlockElement::GetList(array(),	$arFilter);
						while	($arSect	=	$rsSect->GetNext())	{
								$productID[$arSect["ID"]]	=	$arSect["IBLOCK_SECTION_ID"];
								$sectionID[]	=	$arSect["IBLOCK_SECTION_ID"];
						}
						if	($sectionID)	{
								$arFilter	=	array("IBLOCK_ID"	=>	2,	"ID"	=>	$sectionID);
								$sectionID	=	false;
								$rsSect	=	CIBlockSection::GetList(array(),	$arFilter);
								while	($arSect	=	$rsSect->GetNext())	{
										#$productID[$arSect["ID"]] = $arSect["IBLOCK_SECTION_ID"];        
										$sectionID[$arSect["ID"]]	=	$arSect["NAME"];
								}
						}
				}
				?>
				<script>
						window.onload = function () {

								sendEvent('order', 'chart');

								ga('ecommerce:addTransaction', {
										'id': '<?=	$arResult["ORDER"]["ID"]	?>',
										'affiliation': '<?=	$_SERVER['HTTP_HOST'];	?>',
										'revenue': '<?=	$arResult["ORDER"]["PRICE"]	?>',
										'shipping': '<?=	$arResult["ORDER"]["PRICE_DELIVERY"]	?>',
										'tax': ''
								});
				<?	foreach	($arItem	as	$item):	?>
										ga('ecommerce:addItem', {
												'id': '<?=	$arResult["ORDER"]["ID"]	?>',
												'name': '<?=	$item["NAME"]	?>',
												'sku': '<?=	$item["MODULE"]!= "bq.options"?"cat":"op"	?><?=	$item["PRODUCT_ID"]	?>',
												'category': '<?	
																				if($item["MODULE"] == "bq.options"){																						
																						echo "Опция";
																				}else{
																						echo $sectionID[$productID[$item["PRODUCT_ID"]]];
																				}
																				?>',
												'price': '<?=	$item["PRICE"]	?>',
												'quantity': '<?=	(int)	$item["QUANTITY"]	?>'
										});
				<?	endforeach;	?>
								ga('ecommerce:send');
						};
				</script>    
		<?			
		}			
}
else	{
		?>
		<b><?=	GetMessage("SOA_TEMPL_ERROR_ORDER")	?></b><br /><br />

		<table class="sale_order_full_table">
				<tr>
						<td>
		<?=	GetMessage("SOA_TEMPL_ERROR_ORDER_LOST",	Array("#ORDER_ID#"	=>	$arResult["ACCOUNT_NUMBER"]))	?>
		<?=	GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")	?>
						</td>
				</tr>
		</table>
								<?
						}
						?>
