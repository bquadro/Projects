<?
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)
		die();
\Bitrix\Main\Loader::IncludeModule("bq.options");

use	\Bq\Options;

global	$arWatermark,	$arWatermark2;

if	(in_array("project",	$arResult["PROPERTIES"]["PTYPE"]["VALUE_XML_ID"]))	{
		$arResult["PROPERTIES"]["PTYPE"]["VALUE_XML_ID"]	=	false;
		$arResult["PROPERTIES"]["PTYPE"]["VALUE"]	=	false;
}


$arPlan	=	false;
foreach	($arResult["PROPERTIES"]["PLAN"]["VALUE"]	as	$k	=>	$plan)	{
		$arPlan[$k]["NAME"]	=	$arResult["PROPERTIES"]["PLAN"]["DESCRIPTION"][$k];
		if	($arPlan[$k]["NAME"]	==	"")
				$arPlan[$k]["NAME"]	=	"План #"	.	($k	+	1);
		$arPlan[$k]["ID"]	=	$plan;
		$arPlan[$k]["FILE"]	=	CFile::GetFileArray($plan);
		$resize	=	CFile::ResizeImageGet($plan,	array("width"	=>	400,	"height"	=>	350),	BX_RESIZE_IMAGE_PROPORTIONAL,	false,	array($arWatermark,	$arWatermark2));
		$arPlan[$k]["SRC"]	=	$resize["src"];
		$resize	=	CFile::ResizeImageGet($plan,	array("width"	=>	800,	"height"	=>	800),	BX_RESIZE_IMAGE_PROPORTIONAL,	false,	array($arWatermark,	$arWatermark2));
		$arPlan[$k]["FULL_PLAN"]	=	$resize["src"];
}
$arExplication	=	false;
$planFields	=	array(
				'fc'	=>	'PLAN_TSOKOL',
				'f1'	=>	'PLAN_1F',
				'f2'	=>	'PLAN_2F',
				'f3'	=>	'PLAN_3F',
				'f4'	=>	'PLAN_4F',
				'fm'	=>	'PLAN_MANS',
);

foreach	($planFields	as	$planField)	{
		if	(!$arResult["PROPERTIES"][$planField]["VALUE"])
				continue;
		$plan	=	$arResult["PROPERTIES"][$planField]["VALUE"];
		$arExplication[$planField]["NAME"]	=	$arResult["PROPERTIES"][$planField]["NAME"];

		if	($arResult["PROPERTIES"][$planField]["DESCRIPTION"]	!=	"")
				$arExplication[$planField]["NAME"]	=	$arResult["PROPERTIES"][$planField]["DESCRIPTION"];

		$arExplication[$planField]["ID"]	=	$planField;
		$arExplication[$planField]["FILE"]	=	CFile::GetFileArray($plan);
		$resize	=	CFile::ResizeImageGet($plan,	array("width"	=>	800,	"height"	=>	800),	BX_RESIZE_IMAGE_PROPORTIONAL,	false,	array($arWatermark,	$arWatermark2));
		$arExplication[$planField]["SRC"]	=	$resize["src"];
}

foreach	($arResult["MORE_PHOTO"]	as	$k	=>	$photo)	{
		$img	=	CFile::ResizeImageGet($photo,	array("width"	=>	1400,	"height"	=>	1000),	BX_RESIZE_IMAGE_EXACT,	false,	array($arWatermark,	$arWatermark2));
		$arResult["MORE_PHOTO"][$k]["SRC"]	=	$img["src"];
}

$arFacade	=	false;
$facade_height	=	250;
foreach	($arResult["PROPERTIES"]["FACADE"]["VALUE"]	as	$k	=>	$plan)	{
		$arFacade[$k]["NAME"]	=	$arResult["PROPERTIES"]["FACADE"]["DESCRIPTION"][$k];
		$arFacade[$k]["ID"]	=	$plan;
		$arFacade[$k]["FILE"]	=	CFile::GetFileArray($plan);

		$_this_height	=	ceil(273	/	$arFacade[$k]["FILE"]["WIDTH"]	*	$arFacade[$k]["FILE"]["HEIGHT"]);
		if	($_this_height	<	$facade_height)
				$facade_height	=	$_this_height;
}


foreach	($arFacade	as	$k	=>	$plan)	{
		$resize_small	=	CFile::ResizeImageGet(
																		$plan["ID"],	array("width"	=>	273,	"height"	=>	$facade_height),	BX_RESIZE_IMAGE_PROPORTIONAL,	false,	array(array("name"	=>	"sharpen",	"precision"	=>	100),	array("name"	=>	"fillColor",	"color"	=>	0xffffff,	"width"	=>	273,	"height"	=>	$facade_height),	$arWatermark,	$arWatermark2)
		);

		$resize	=	CFile::ResizeImageGet($plan["ID"],	array("width"	=>	800,	"height"	=>	800),	BX_RESIZE_IMAGE_PROPORTIONAL,	false,	array($arWatermark,	$arWatermark2));
		$arFacade[$k]["SRC"]	=	$resize_small["src"];
		$arFacade[$k]["FULL"]	=	$resize["src"];
}

$arPlanMin	=	false;
if	($arResult["PROPERTIES"]["PLAN_MIN_FILE"]["VALUE"])	{
		$arPlanMin["ID"]	=	$arResult["PROPERTIES"]["PLAN_MIN_FILE"]["VALUE"];
		$arPlanMin["FILE"]	=	CFile::GetFileArray($arResult["PROPERTIES"]["PLAN_MIN_FILE"]["VALUE"]);
		$resize	=	CFile::ResizeImageGet($arResult["PROPERTIES"]["PLAN_MIN_FILE"]["VALUE"],	array("width"	=>	310,	"height"	=>	310	/	$arPlanMin["FILE"]["WIDTH"]	*	$arPlanMin["FILE"]["HEIGHT"]),	BX_RESIZE_IMAGE_EXACT,	false,	array($arWatermark,	$arWatermark2));
		$arPlanMin["SRC"]	=	$resize["src"];
}

$propject_variant	=	0;
if	($arResult["PROPERTIES"]["PROJECT_COUNT"]["VALUE"]	&&	$arResult["PROPERTIES"]["LOTS"]["VALUE"]	!=	"")	{
		$propject_variant	=	(int)	$arResult["PROPERTIES"]["PROJECT_COUNT"]["VALUE"];
}

//Временный расчет стоимости
$price_full	=	false;
if	($arResult["PROPERTIES"]["PRICE_FULL"]["VALUE"])
		$price_full	=	catalog_price_format($arResult["PROPERTIES"]["PRICE_FULL"]["VALUE"]);

if	($arResult["PROPERTIES"]["PRICE_CALC"]["VALUE_ENUM_ID"]	==	'222')
		$price_full	=	"~"	.	$price_full;

if	(is_array($arResult["PROPERTIES"]["MATERIAL"]["~VALUE"])	&&	count($arResult["PROPERTIES"]["MATERIAL"]["~VALUE"])	>=	1)	{
		$price_max	=	0;
		foreach	($arResult["PROPERTIES"]["MATERIAL"]["~VALUE"]	as	$k	=>	$val)	{
				if	($arResult["MATERIAL"][$val]["UF_PRICE"]	>	$price_max)
						$price_max	=	$arResult["MATERIAL"][$val]["UF_PRICE"];
		}
		if	($price_full	==	FALSE	&&	$arResult["PROPERTIES"]["AREA1"]["VALUE"])	{
				$price_full	=	"~"	.	catalog_price_format($price_max	*	$arResult["PROPERTIES"]["AREA1"]["VALUE"]);
		}
}

$ready_to_buy = in_array(10, $arResult["PROPERTIES"]["PTYPE"]["VALUE_ENUM_ID"]);

?>

<div class="b_project" data-product-id="<?=	$arResult["ID"]	?>">			
		<?	$APPLICATION->IncludeComponent("bitrix:breadcrumb",	"main",	Array(),	false);	?>		
		<h1><?=	strtoupper($arResult["PROPERTIES"]["CODE"]["VALUE"])	?> <?=	$arResult["NAME"]	?></h1>
		<div class="b_ico_line no_select">
				<span class="ico complated comparison" data-rel="<?=	$arResult["ID"]	?>">Сравнить проект</span>
				<span class="ico heart projects_heart" title="Избранные проекты" data-rel="<?=	$arResult["ID"]	?>">В избранное</span>

				<!-- share this -->
				<div id="share_this">
						<span class='st_vkontakte_hcount' displayText='Vkontakte'></span>
						<span class='st_facebook_hcount' displayText='Facebook'></span>
						<span class='st_plusone_hcount' displayText='Google +1'></span>
				</div>
				<div class="b_right">
						<!--
						<a href="#" class="ico pdf">PDF</a>
						<a href="#" class="ico print">Распечатать</a>
						<a href="#" class="ico mail">Выслать на почту</a>								
						!-->
				</div>
		</div>
		<div class="clear"></div>
		<div class="b_fotorama">
				<div class="b_image">
						<div class="fotorama" data-maxheight="100%" data-thumbmargin="0" data-thumbwidth="108" data-thumbheight="75" data-navposition="bottom" data-minwidth="100%" data-nav="thumbs" data-width="100%" data-loop="true" data-keyboard="true" data-allowfullscreen="false" data-fit="cover">										
								<?	if	($arResult["MORE_PHOTO"]	||	$arResult["PROPERTIES"]["VIDEO_LINK"]["VALUE"]):	?> 
										<?	foreach	($arResult["MORE_PHOTO"]	as	$photo):	?>
												<img src="<?=	$photo["SRC"]	?>" <?=	$photo["WIDTH"]	<	650	||	$photo["HEIGHT"]	<	450	?	'data-fit="none"'	:	""	?> >
										<?	endforeach;	?>
										<?	foreach	($arResult["PROPERTIES"]["VIDEO_LINK"]["VALUE"]	as	$link):	?>
												<a href="<?=	$link	?>"></a>
										<?	endforeach;	?>			
								<?	else:	?>
										<div>&nbsp;</div>
								<?	endif;	?>
						</div>								
				</div>

				<div class="b_desc">

						<? if($ready_to_buy):?>
  						<div class="cf">
  						  Подготовка проекта:
  						  <div class="b_status">
  										<?=	$arResult["PROPERTIES"]["DAYS_READY"]["VALUE"]	?	$arResult["PROPERTIES"]["DAYS_READY"]["VALUE"]	.	' '	.	declOfNum((int)	$arResult["PROPERTIES"]["DAYS_READY"]["VALUE"],	array("рабочий день",	"рабочих дня",	"рабочих дней"))	:	'Готов к отправке';	?>
  								</div>
  						</div>	
      			<? endif;?>
						<?	if	($arResult["COMPANY"]):	?>													
								<?	if	($arResult["PROPERTIES"]["COMPANY_CODE"]["VALUE"]):	?><div class="b_co_code">Артикул проекта: <b><?=	$arResult["PROPERTIES"]["COMPANY_CODE"]["VALUE"]	?></b></div><?	endif;	?>
								<div class="b_co_name">Компания: <?=	$arResult["COMPANY"]["NAME"]	?></div>			
								<?	if	($arResult["COMPANY"]["PREVIEW_PICTURE"]):	?>
										<div class="b_co_logo"><img src="<?=	$arResult["COMPANY"]["PREVIEW_PICTURE"]	?>" alt="<?=	$arResult["COMPANY"]["NAME"]	?>"></div>
								<?	endif;	?>
								<div class="pr_contact">
										<a href="<?=	$arResult["COMPANY"]["DETAIL_PAGE_URL"]	?>">Контакты</a>
										<a href="<?=	$arResult["COMPANY"]["DETAIL_PAGE_URL"]	?>">Другие проекты</a>
								</div>																		
								<div class="cont">
										<?	if	($arResult["COMPANY"]["PROPERTIES"]["PHONE"]["VALUE"]):	?>Телефон: &nbsp;&nbsp; <strong><?=	$arResult["COMPANY"]["PROPERTIES"]["PHONE"]["VALUE"]	?></strong><br><?	endif;	?>
										<?	if	($arResult["COMPANY"]["PROPERTIES"]["SKYPE"]["VALUE"]):	?>Skype: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="skype:<?=	$arResult["COMPANY"]["PROPERTIES"]["SKYPE"]["VALUE"]	?>" class="skype"><strong><?=	$arResult["COMPANY"]["PROPERTIES"]["SKYPE"]["VALUE"]	?></strong></a><br><?	endif;	?>										
								</div>
								<!--
								<div class="price_select">										
										<a href="#" class="b_select_price">Стоимость постройки в Москве</a>								
										<div class="b_hide">
												<a href="#" class="active">в Москве</a>
												<a href="#">Стоимость постройки в Саратове</a>
												<a href="#">Стоимость постройки в Санкт-Петербурге</a>
												<a href="#">Стоимость постройки в Владивостоке</a>
										</div>
								</div>
								!-->
								<? endif;

						$hide_price	=	false;
						if	($arResult["PRICES"]["RETAIL"]["CAN_ACCESS"]	==	"Y"):
								?>
								<div class="price_title">Стоимость проекта</div>
								<div class="b_price">
										<div class="b_left">
												<?
												CModule::IncludeModule("sale");
												if	($arResult["PRICES"]["RETAIL"]["VALUE"]	>	$arResult["PRICES"]["RETAIL"]["DISCOUNT_VALUE"]):
														?><div class="b_price_old"><?=	catalog_price_format($arResult["PRICES"]["RETAIL"]["VALUE"]);	?></div><?
												endif;
												?>
												<div class="b_price_new"><?=	catalog_price_format($arResult["PRICES"]["RETAIL"]["DISCOUNT_VALUE"])	?></div>
										</div>
								</div>										

								<a class="blue_btn_300" data-id="<?	echo	$arResult['ID'];	?>" onclick="return add2cartclick(this);" href="#add2cart"><span class="cart_ico">Купить проект</span></a>		
								<?
						elseif	($arResult["COMPANY"]):
								$hide_price	=	true;
								?>
								<div class="price_title">Стоимость постройки</div>
								<div class="b_price">
										<div class="b_left">
												<?	if	($arResult["PROPERTIES"]["PRICE_FULL_OLD"]["VALUE"]):	?><div class="b_price_old"><?=	catalog_price_format($arResult["PROPERTIES"]["PRICE_FULL_OLD"]["VALUE"]);	?></div><?	endif;	?>
												<?	if	($arResult["PROPERTIES"]["PRICE_FULL"]["VALUE"]):	?><div class="b_price_new"><?=	catalog_price_format($arResult["PROPERTIES"]["PRICE_FULL"]["VALUE"]);	?></div><?	endif;	?>
												<!-- <a href="#" class="l_subscribe">Подписаться на изменение цены</a> !-->
										</div>
										<div class="project_smeta"></div>
								</div>														
								<a href="#order_form" class="blue_btn_300 add2basket" onclick="return add2basketclick(this);" data-id="<?=	$arResult["ID"]	?>">Заказать строительство</a>
						<?	else:	?>
								<div class="clear"></div>
								<br>
						<?	endif;	?>																
						<div class="clear"></div>

						<div class="b_dop_link no_active">
								<div class="p_ico ico_mirrow first"><span></span>Зеркальный<br>проект</div>
								<div class="p_ico ico_color"><span></span>Цветовые<br>решения</div>
								<div class="p_ico ico_modifier last"><span></span>Изменить<br>проект</div>
								<div class="clear"></div>
						</div>								
						<a href="#cell_form" class="b_more quest_form" data-id="<?=	$arResult["ID"]	?>">Задать вопрос по проекту</a>

						<?	if	($price_full	&&	!$hide_price):	?>
								<br><br>
								Стоимость строительства:<br>
								<b><?=	$price_full	?></b>
						<?	endif;	?>
				</div>

				<div class="item_head ">
						<span class="number"><?=	$arResult["PROPERTIES"]["CODE"]["VALUE"]	?></span>
						<?	if	($arResult["PROPERTIES"]["AREA1"]["VALUE"]):	?><span class="area"><?=	$arResult["PROPERTIES"]["AREA1"]["VALUE"]	?></span><?	endif;	?>
						<?	if	($arResult["PROPERTIES"]["PTYPE"]["VALUE"]):	?><span class="type"><?=	$arResult["PROPERTIES"]["PTYPE"]["VALUE"][0]	?></span><?	endif;	?>			
				</div>
				<div class="clear"></div>
		</div>

		<div class="b_tab">
				<a href="#tab1" class="active">О проекте</a>
				<!-- <a href="#">Услуги</a> !-->
				<a href="#tab2">Состав проекта</a>				
				<?	if	($propject_variant	>	1):	?>
						<a href="#tab3">Варианты<sup><?=	$propject_variant	-	1;	?></sup></a>
				<?	endif;	?>
				<!-- 
				<a href="#">Строительство</a>
				<a href="#">Построенные дома</a>
				<a href="#">Интерьеры</a>
				<a href="#">Комментарии</a>						                                          
				!-->
		</div>

		<div class="b_projet_desc b_all_tab">
				<div class="b_page_1 active" id="tab1">
						<div class="b_page_desc">
								<?
								//Вывод минимальных размеров
								$__plan_mini	=	$arPlanMin	||	$arResult["PROPERTIES"]["PLAN_MIN_WIDTH"]["VALUE"]	||	$arResult["PROPERTIES"]["PLAN_MIN_HEIGHT"]["VALUE"];
								if	($arPlan	||	$arExplication	||	$__plan_mini):
										?>
										<div class="b_title">Планы помещений</div>
										<!-- <a href="#" class="title_link">Адаптация фундамента</a> !-->		
										<?	if	($arExplication)	{	?>
												<div class="b_plane_list <?=	!$__plan_mini	?	"b_plane_list_full"	:	""	?>">
														<?	foreach	($arExplication	as	$k	=>	$plan):	?>
																<a href="/ajax/explication.php?ID=<?=	$arResult["ID"];	?>&CODE=<?=	$plan["ID"]	?>" rel="explication" class="plane fancybox_ajax">
																		<div class="b_name"><?=	$plan["NAME"]	?></div>
																		<div class="clear"></div>
																		<img src="<?=	$plan["SRC"]	?>" alt="<?=	$plan["NAME"]	?>" />
																</a>
														<?	endforeach;	?>
												</div>
												<?
										}else
										if	($arPlan)	{
												?>
												<div class="b_plane_list <?=	!$__plan_mini	?	"b_plane_list_full"	:	""	?>">
														<?	foreach	($arPlan	as	$k	=>	$plan):	?>
																<a href="<?=	$plan["FULL_PLAN"]	?>" class="plane fancybox_img" rel="plan" title="<?=	$plan["NAME"]	?>" >
																		<div class="b_name"><?=	$plan["NAME"]	?></div>
																		<div class="clear"></div>
																		<img src="<?=	$plan["SRC"]	?>" alt="<?=	$plan["NAME"]	?>" />
																</a>
														<?	endforeach;	?>
												</div>
										<?	}	?>

										<?	if	($__plan_mini):	?>
												<div class="plane_min">
														<div class="b_name">Минимальный участок</div>
														<?	if	($arPlanMin):	?><img src="<?=	$arPlanMin["SRC"]	?>" alt="Минимальный участок"><?	endif;	?>
														<div class="clear"></div>
														<?	if	($arResult["PROPERTIES"]["PLAN_MIN_WIDTH"]["VALUE"]):	?>
																<div class="b_param">
																		<div class="p_name">Ширина</div> 
																		<div class="p_val"><?=	$arResult["PROPERTIES"]["PLAN_MIN_WIDTH"]["VALUE"]	?>  м&#178;</div>
																</div>
														<?	endif;	?>
														<?	if	($arResult["PROPERTIES"]["PLAN_MIN_HEIGHT"]["VALUE"]):	?>
																<div class="b_param">
																		<div class="p_name">Длина</div> 
																		<div class="p_val"><?=	$arResult["PROPERTIES"]["PLAN_MIN_HEIGHT"]["VALUE"]	?>  м&#178;</div>
																</div>
														<?	endif;	?>																			
												</div>			
										<?	endif;	?>
								<?	endif;	?>
								<?	if	($arFacade):	?>								
										<div class="b_title">Фасады</div>
										<div class="b_fasads">										
												<?	foreach	($arFacade	as	$k	=>	$facade):	?>
														<a class="b_fasad <?	# (($k+1)%4)==0?"last":""							?> fancybox_img" rel="fasad" href="<?=	$facade["FULL"]	?>" title="<?=	$facade["NAME"]	?>" ><img src="<?=	$facade["SRC"]	?>" alt="<?=	$facade["NAME"]	?>"></a>
												<?	endforeach;	?>
										</div>
								<?	endif;	?>
								<?	if	($arResult["DETAIL_TEXT"]):	?>
										<div class="b_title">Описание проекта</div>
										<div class="b_full_desc">
												<?=	$arResult["DETAIL_TEXT"]	?>
										</div>										
								<?	endif;	?>
								<?	if	($arResult["PROPERTIES"]["MORE_FILE"]["VALUE"]):	?>
										<div class="b_title">Файлы для скачивания</div>
										<div class="file_list">
												<?
												foreach	($arResult["PROPERTIES"]["MORE_FILE"]["VALUE"]	as	$k	=>	$file):
														$arFile	=	CFile::GetFileArray($file);

														$name	=	$arFile["FILE_NAME"];
														$ico	=	strtoupper(GetFileExtension($arFile["FILE_NAME"]));
														$ico_color	=	false;
														if	(preg_match("/^(.*?)\.([\w\d]{2,})$/i",	$arFile["FILE_NAME"],	$arRes))	{
																$name	=	$arRes[1];
														}
														switch	($ico)	{
																case	"PDF":
																		$ico_color	=	"ico_red";
																		break;
																case	"DOC":
																case	"DOCX":
																		$ico_color	=	"ico_blue";
																		break;
																default	:
																		$ico_color	=	"ico_grey";
																		break;
														}
														if	(strlen($ico)	>=	4)
																$ico_color.=" ico_size_"	.	strlen($ico);

														$name	=	$arFile["DESCRIPTION"]	!=	""	?	$arFile["DESCRIPTION"]	:	$name;
														?>												
														<a href="<?=	$arFile["SRC"]	?>" target="_blank" class="b_file <?=	$ico_color	?> ">
																<span class="ico"><span class="ico2"></span><?=	$ico	?></span>
																<span class="b_name"><?=	$name	?></span>
																<div class="clear"></div>
																<span class="b_param">Скачать, <?=	$ico	?>, <?=	CFile::FormatSize($arFile["FILE_SIZE"])	?></span>														
														</a>					
												<?	endforeach;	?>
										</div>		
								<?	endif;	?>
								<div class="clear"></div>
								<? // if($ready_to_buy):?>
                   <div id="b_sim_projects" class="cf"></div>
                    <script>$(document).ready(function(){ loadSimProjects('<?=$arResult["ID"];?>'); });</script>
                   <div class="clear"></div>
								<? ///	 endif;?>
						</div>
						<div class="b_right">
								<?	if	($arResult["TECH_1"]	!=	false	||	$arResult["TECH_2"]	!=	false):	?>
										<div class="b_right_box b_tech_param">
												<div class="b_title">Технические характеристики</div>
												<div class="b_padding">
														<?	if	($arResult["TECH_1"]):	?>
																<div class="b_title2">Общие</div>
																<?
																foreach	($arResult["TECH_1"]	as	$tech):
																		?>
																		<div class="param">
																				<div class="p_name"><?=	$tech["NAME"]	?></div>
																				<?	if	($tech["DESCRIPTION"]):	?><div class="q" data-text="<?=	$tech["DESCRIPTION"]	?>" ></div><?	endif;	?>
																				<div class="b_value"><?=	$tech["VALUE"]	?></div>
																		</div>								
																<?	endforeach;	?>
														<?	endif;	?>				
														<?	if	($arResult["TECH_2"]):	?>
																<div class="b_title2">Дополнительные</div>
																<?
																foreach	($arResult["TECH_2"]	as	$tech):
																		?>
																		<div class="param">
																				<div class="p_name"><?=	$tech["NAME"]	?></div>
																				<?	if	($tech["DESCRIPTION"]):	?><div class="q" data-text="<?=	$tech["DESCRIPTION"]	?>" ></div><?	endif;	?>
																				<div class="b_value"><?=	$tech["VALUE"]	?></div>
																		</div>							
																<?	endforeach;	?>
														<?	endif;	?>																
														<!-- <a href="#" class="p_more">Полная смета по проекту</a> !-->
												</div>
										</div>
								<?	endif;	?>
								<!-- 
								<div class="b_right_box">
										<div class="b_title">Варианты материалов</div>
										<div class="b_more_link">
												<b>Стены</b><br>
												<a href="#">газобетон</a>, <a href="#">керамические</a>, <a href="#">блоки</a>
										</div>
										<div class="b_more_link">
												<b>Кровля</b></br>
										керамическая черепица, металлочерепица, цементно-песчаная черепица
										</div>
										<div class="b_more_link">
												<b>Перекрытие</b></br>												
												монолитные перекрытия
										</div>
								</div>
								!-->
						</div>
				</div>
				<div class="b_page_3" id="tab2">
						<div class="b_title">Состав проекта</div>
						<div class="clear"></div>
						<?
						global	$USER;
						if	($USER->isAdmin()):
								$arOptionStatus	=	\Bq\Options\OptionsTable::getStatusList();

								$params	=	array(
												"filter"	=>	array(
																"ACTIVE"	=>	"Y",
																"SECTION_ID"	=>	array(0,	$arResult["IBLOCK_SECTION_ID"]),
												),
												"order"	=>	array(
																"SORT"	=>	"ASC"
												)
								);
								$res	=	Bq\Options\OptionsTable::getList($params);
								$arIDs	=	false;
								$arOptions	=	false;
								while	($ar	=	$res->fetch())	{
										$arOptions[$ar["ID"]]	=	$ar;
										$arIDs[]	=	$ar["ID"];
								}
								if	($arIDs)	{
										$params	=	array(
														"filter"	=>	array(
																		"OPTIONS_ID"	=>	$arIDs,
																		"ELEMENT_ID"	=>	array($arResult["ID"])
														),
														"order"	=>	array("LEVEL"	=>	"ASC")
										);

										if	((int)	$arResult["PROPERTIES"]["ARCHITECT"]["VALUE"]	>	0)	{
												$params["filter"]["ELEMENT_ID"][]	=	$arResult["PROPERTIES"]["ARCHITECT"]["VALUE"];
										}
										if	((int)	$arResult["PROPERTIES"]["COMPANY"]["VALUE"]	>	0)	{
												$params["filter"]["ELEMENT_ID"][]	=	$arResult["PROPERTIES"]["COMPANY"]["VALUE"];
										}

										$res	=	Bq\Options\TreeTable::getList($params);
										$arLevel	=	array_flip(Bq\Options\TreeTable::getLevel());
										foreach	($arLevel	as	$k	=>	$v)	{
												switch	($v)	{
														case	IBLOCK_CATALOG:
																$arLevel[$k]	=	"Товар";
																break;
														case	IBLOCK_ARCHITECT:
																$arLevel[$k]	=	"Архитектор";
																break;
														case	IBLOCK_BUILDING:
																$arLevel[$k]	=	"Компания";
																break;
												}
										}
										while	($ar	=	$res->fetch())	{
												if	($ar["PRICE"]	!=	"")	{
														$arOptions[$ar["OPTIONS_ID"]]["PRICE"]	=	$ar["PRICE"];
														$arOptions[$ar["OPTIONS_ID"]]["PRICE_LEVEL"]	=	$arLevel[$ar["LEVEL"]];
												}

												if	($ar["DEADLINE"]	!=	"")	{
														$arOptions[$ar["OPTIONS_ID"]]["DEADLINE"]	=	$ar["DEADLINE"];
														$arOptions[$ar["OPTIONS_ID"]]["DEADLINE_LEVEL"]	=	$arLevel[$ar["LEVEL"]];
												}
												if	($ar["STATUS"]	!=	"")	{
														$arOptions[$ar["OPTIONS_ID"]]["STATUS"]	=	$ar["STATUS"];
														$arOptions[$ar["OPTIONS_ID"]]["STATUS_LEVEL"]	=	$arLevel[$ar["LEVEL"]];
												}
										}
								}
								$__arOptions	=	$arOptions;
								$arOptions	=	false;
								foreach	($__arOptions	as	$option)	{
										if	($option["STATUS"]	!=	3)	{
												$arOptions[$option["STATUS"]][]	=	$option;
										}
								}
								?>
								<div class="b_project_big_text">											
										<div class="b_title">--- Для теста ---</div>
										<br>
										<?
										foreach	($arOptionStatus	as	$status_id	=>	$status):
												if	(isset($arOptions[$status_id])):
														
														echo $status["NAME"]."<br>";
														foreach	($arOptions[$status_id]	as	$option):
																$option["DEADLINE"] = ceil($option["DEADLINE"]);
																echo	" -- ".$option["NAME"]	.	" <b>"	.	catalog_price_format($option["PRICE"])	.	"</b>, доступность: {$option["DEADLINE"]}<br>";
														endforeach;
														echo "<hr>";
												endif;
										endforeach;
										?>
								</div>
								<?
						endif;
						?>
						<?	if	($arResult["PROPERTIES"]["BIG_TEXT"]["VALUE"]):	?>
								<div class="b_project_big_text">								
										<?=	$arResult["PROPERTIES"]["BIG_TEXT"]["~VALUE"]["TEXT"]	?>
								</div>
						<?	endif;	?>
				</div>
				<?	if	($propject_variant	>	1):	?>		
						<?
						$arLots	=	array();
						$arFilterLots	=	Array("IBLOCK_ID"	=>	2,	"ACTIVE_DATE"	=>	"Y",	"ACTIVE"	=>	"Y");
						$arFilterLots["!ID"]	=	$arResult["ID"];
						$arFilterLots["PROPERTY"]["LOTS"]	=	$arResult["PROPERTIES"]["LOTS"]["VALUE"];

						$resLots	=	CIBlockElement::GetList(Array(),	$arFilterLots,	false);
						while	($obLot	=	$resLots->GetNextElement())	{
								$arFieldsLot	=	$obLot->GetFields();
								$arLots[$arFieldsLot['ID']]	=	$arFieldsLot;
						}
						?>		
						<div class="b_page_3" id="tab3"><div class="b_title"><?	if	($propject_variant	>	2):	?>Варианты проекта<?	else:	?>Вариант проекта<?	endif;	?>&nbsp;&nbsp;&nbsp;<span><a class="comparison-group" href="/catalog/comparison/?event=ADD_TO_COMPARE_LIST&ID=<?=	$arResult["ID"];	?>&LOTS=<?=	implode(',',	array_keys($arLots));	?>">Сравнить варианты</a></span></div>
								<div class="clear"></div>
								<?
								global	$arrFilterLots;
								$arrFilterLots["!ID"]	=	$arResult["ID"];
								$arrFilterLots["PROPERTY"]["LOTS"]	=	$arResult["PROPERTIES"]["LOTS"]["VALUE"];
								$APPLICATION->IncludeComponent("bitrix:catalog.section",	"project_lots",	array(
												"IBLOCK_TYPE"	=>	"catalog",
												"IBLOCK_ID"	=>	"2",
												"SECTION_ID"	=>	"false",
												"SECTION_CODE"	=>	"",
												"SECTION_USER_FIELDS"	=>	array(
																0	=>	"",
																1	=>	"",
												),
												"ELEMENT_SORT_FIELD"	=>	"sort",
												"ELEMENT_SORT_ORDER"	=>	"asc",
												"FILTER_NAME"	=>	"arrFilterLots",
												"INCLUDE_SUBSECTIONS"	=>	"Y",
												"SHOW_ALL_WO_SECTION"	=>	"Y",
												"PAGE_ELEMENT_COUNT"	=>	"12",
												"LINE_ELEMENT_COUNT"	=>	"1",
												"PROPERTY_CODE"	=>	array(
																0	=>	"STATUS",
																1	=>	"",
												),
												"OFFERS_LIMIT"	=>	"0",
												"SECTION_URL"	=>	"",
												"DETAIL_URL"	=>	"",
												"BASKET_URL"	=>	"/personal/basket.php",
												"ACTION_VARIABLE"	=>	"action",
												"PRODUCT_ID_VARIABLE"	=>	"id",
												"PRODUCT_QUANTITY_VARIABLE"	=>	"quantity",
												"PRODUCT_PROPS_VARIABLE"	=>	"prop",
												"SECTION_ID_VARIABLE"	=>	"SECTION_ID",
												"AJAX_MODE"	=>	"N",
												"AJAX_OPTION_JUMP"	=>	"N",
												"AJAX_OPTION_STYLE"	=>	"Y",
												"AJAX_OPTION_HISTORY"	=>	"N",
												"CACHE_TYPE"	=>	"A",
												"CACHE_TIME"	=>	"36000000",
												"CACHE_GROUPS"	=>	"Y",
												"META_KEYWORDS"	=>	"-",
												"META_DESCRIPTION"	=>	"-",
												"BROWSER_TITLE"	=>	"-",
												"ADD_SECTIONS_CHAIN"	=>	"N",
												"DISPLAY_COMPARE"	=>	"N",
												"SET_TITLE"	=>	"N",
												"SET_STATUS_404"	=>	"N",
												"CACHE_FILTER"	=>	"N",
												"PRICE_CODE"	=>	array("BASE"),
												"USE_PRICE_COUNT"	=>	"N",
												"SHOW_PRICE_COUNT"	=>	"1",
												"PRICE_VAT_INCLUDE"	=>	"Y",
												"PRODUCT_PROPERTIES"	=>	"",
												"USE_PRODUCT_QUANTITY"	=>	"N",
												"DISPLAY_TOP_PAGER"	=>	"N",
												"DISPLAY_BOTTOM_PAGER"	=>	"N",
												"PAGER_TITLE"	=>	"Товары",
												"PAGER_SHOW_ALWAYS"	=>	"N",
												"PAGER_TEMPLATE"	=>	"",
												"PAGER_DESC_NUMBERING"	=>	"N",
												"PAGER_DESC_NUMBERING_CACHE_TIME"	=>	"36000",
												"PAGER_SHOW_ALL"	=>	"N",
												"AJAX_OPTION_ADDITIONAL"	=>	"",
																),	false,	array(
												"ACTIVE_COMPONENT"	=>	"Y",
												"HIDE_ICO"	=>	"Y"
																)
								);
								?>						
								<div class="clear"></div>
						</div>
				<?	endif;	?>				

		</div>
		<div class="clear"></div>
</div>