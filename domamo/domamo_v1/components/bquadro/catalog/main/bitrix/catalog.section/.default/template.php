<?

switch	($_GET["sort"])	{
		case	"price":
				$sort	=	"price";
				break;
		case	"raiting":
				$sort	=	"raiting";
				break;
		case	"area":
				$sort	=	"area";
				break;
		case	"room":
				$sort	=	"room";
				break;	
		default	:
				$sort	=	"raiting";
				break;
}
switch	($_GET["order"])	{
		case	"desc":
				$order	=	"desc";
				break;
		default	:
				$order	=	"asc";
				break;
}

$promo = false;
if( $_GET["promo"] == "new" || $_GET["promo"] == "best" || $_GET["promo"] == "sale"){
		$promo = $_GET["promo"];
}

$arSortList = array(
				"raiting"=> "популярности",
				"area"=> "площади",
				"room"=> "кол. комнат",
				"price"=> "стоимости",												
		);
?>
<div class="b_cat_head">
		
		<?
		
		$this_tag	=	$arParams["SECTION_TAG"];;
		
		$sql = "SELECT 
						bq_tags_list.* " . ($this_tag?(", bq_tags_parent.NAME_LINK"):""). "
				FROM `bq_tags_list`
				".($this_tag?"LEFT JOIN bq_tags_parent ON ( bq_tags_parent.TAG_ID =  bq_tags_list.ID )":"")."
				WHERE 
						SECTION_ID = '{$arResult["ID"]}' AND 						
					  ".( $this_tag ?	"bq_tags_parent.PARENT_ID =  '".$this_tag["ID"]."'  ":"SHOW_MAIN = 'Y' ")."						
				ORDER BY 
				".($this_tag?"	bq_tags_parent.SORT ASC":"	bq_tags_list.SORT ASC")."
			";
			$res = $DB->Query($sql);
			$arTag = false;
			while( $_tag = $res->GetNext() ){
					$arTag[] = $_tag;
			}				
		$APPLICATION->IncludeComponent("bitrix:breadcrumb",	"main",	Array(),	false);	
		?>
		<h1><?=($this_tag)?$this_tag["NAME"]:$arResult["NAME"]?></h1>
		<?if($arTag):?>
				
				<div class="b_tags">										
						<? 
						$i=0;
						foreach	($arTag as $tag):
								$i++;
								?>
								<a href="<?=$arResult["SECTION_PAGE_URL"]?><?=$tag["CODE"]?>/" class="<?=$i>16?"hide":""?>"><?= $tag["NAME_LINK"]!=""?$tag["NAME_LINK"]:$tag["NAME_SHOT"]?></a> 
						<?	endforeach;?>
						<?if($i>16):?>
								<a href="#show_all" class="show_all show">Показать все метки</a>
								<a href="#hide_all" class="show_all hide hide_tags">Скрыть метки</a>
						<?endif;?>
						<div class="clear"></div>
				</div>
		<?else:?>
				<br>
		<?endif;?>		
				
		<div class="b_catalog_nav">
				<a href="/catalog/comparison/" class="b_complated_btn compare-nav">Сравнить <span class="hide_1400 b_count_html"></span></a>
				<div class="b_order_list">
						<div class="active">Сортировать по <?=$arSortList[$sort]?></div>
						<div class="b_hide">
								<?
								foreach	($arSortList as $k=>$sort_name):
										if ($k !== $sort) {
												?><a href="<?=	$APPLICATION->GetCurPageParam("sort=".$k."&order=asc",	array("sort",	"order"))	?>"><?=$sort_name?></a><?
										};												
								endforeach;
								?>
						</div>
				</div>
				<div class="b_order_sort">
						<a href="<?=	$APPLICATION->GetCurPageParam("sort=".$sort."&order=asc",	array("sort",	"order"))	?>" class="asc <?= $order=="asc"?"active":""?>" title="сортировать по возрастанию"></a>
						<a href="<?=	$APPLICATION->GetCurPageParam("sort=".$sort."&order=desc",	array("sort",	"order"))	?>" class="desc <?= $order=="desc"?"active":""?>" title="сортировать по убыванию"></a>
				</div>
				<div class="b_promo">
						<?if($promo == "new"):?>
								<a href="<?=	$APPLICATION->GetCurPageParam("",	array("promo"))	?>" class="new active">new</a>
						<?else:?>
								<a href="<?=	$APPLICATION->GetCurPageParam("promo=new",	array("promo"))	?>" class="new">new</a>
						<?endif;?>
						<?if($promo == "best"):?>
								<a href="<?=	$APPLICATION->GetCurPageParam("",	array("promo"))	?>" class="best active">best</a>
						<?else:?>
								<a href="<?=	$APPLICATION->GetCurPageParam("promo=best",	array("promo"))	?>" class="best">best</a>
						<?endif;?>
						<?if($promo == "sale"):?>
								<a href="<?=	$APPLICATION->GetCurPageParam("",	array("promo"))	?>" class="sale active">sale</a>
						<?else:?>
								<a href="<?=	$APPLICATION->GetCurPageParam("promo=sale",	array("promo"))	?>" class="sale">sale</a>
						<?endif;?>												
				</div>
				<?if	($arParams["DISPLAY_TOP_PAGER"]):?>
						<?=($arResult["NAV_STRING"]);?>
				<?endif;?>				
		</div>
</div>
<?if(count($arResult["ITEMS"]) > 0):?>
<div class="projects cat_projects">
		<div class="wrap_item"><div class="wrap_item2">				
				<? include	$_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/components/cataog_card_mini.tpl.php';?>								
		</div></div>
</div>				
<?else:?>
		<div class="projects_message">По вашему запросу ничего не найдено</div>
<?endif;?>
<?if	($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<div class="b_bot_pagen"><?=($arResult["NAV_STRING"]);?></div>
<?endif;?>


<?if($arParams["SECTION_TAG"]["DESCRIPTION"]!="" || $arResult["DESCRIPTION"]):?>		
		<div class="b_fot_info_cat">
				<div class="fot_info ">
						<div class="wrap_item b_wrapper">
								<?if($arParams["SECTION_TAG"]):?>
										<div class="item_full">
												<?
												$res = bqTag::GetList(null,array("ID"=>$arParams["SECTION_TAG"]['ID']));
												if	($_tag	=	$res->GetNext())	{
														echo 	$_tag["DESCRIPTION"];			
												}
												//echo 	$arTag["DESCRIPTION"];																							
												?>
										</div>
								<?elseif($arResult["DESCRIPTION"]):?>
											<div class="item_full">
												<?= $arResult["DESCRIPTION"];?>
										</div>							
								<?else:?>								
										<div class="item_full"></div>
										<?/*?>
									 <div class="item">
												<span class="title">Коротко о нас или как правильно выбрать проект своего дома</span>
												<p>Компания Россия - это эксклюзивный представитель международного архитектурного бюро  на территории Российской Федерации. Компания занимается продажей типовых проектов частных домов , предоставлением дополнительных услуг для их комплексной реализации, а также индивидуальным проектированием.</p>
												<a class="read_more" href="#">Полный текст</a>
									 </div>
									<div class="item">
												<span class="title">Индивидуальное проектирование</span>
												<p>Компания Россия - это эксклюзивный представитель международного архитектурного бюро  на территории Российской Федерации. Компания занимается продажей типовых проектов частных домов, предоставлением дополнительных услуг для их комплексной реализации, а также индивидуальным проектированием.</p>
									 </div>														 
										 */?>				
								<?endif;?>							
								<div class="clear"></div>
						</div>
						<a href="/zakaz-proekta/" class="item zakaz">
								Как заказать проект<br> дома?
						</a>						
				</div>
		</div>	
		<?endif;?>