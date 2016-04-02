<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
		die();
$this->setFrameMode(true);

if(count($arResult["ITEMS"])):
?>
<div class="front_news b_wrapper">
		<div class="fon">
				<div class="top_line">
						<a href="/news/" class="novoe">Hовое на сайте</a>
						<a class="bread" href="/news/">Новости</a>
						<a class="bread" href="/article/">Полезные статьи по строительству</a>
				</div>
				<div class="wrap_item">
						<?
						$i = 0;
						foreach($arResult["ITEMS"] as $arItem):
								$i++;
								$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
								$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
																
								?>
								<div class="item item_<?=$i?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
										<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
												<span class="date"><?= $arItem["DISPLAY_ACTIVE_FROM"]?></span>
										<?endif?>																
										<a class="state" href="<?= $arItem["DETAIL_PAGE_URL"]?>"><?= $arItem["NAME"]?></a>
										<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
												<div class="b_desc"><?= $arItem["PREVIEW_TEXT"];?></div>
										<?endif;?>																	
										<a class="read_more" href="<?= $arItem["DETAIL_PAGE_URL"]?>" title="Подробнее"><?=$arItem["PROPERTIES"]["LINK_MORE"]["VALUE"]?$arItem["PROPERTIES"]["LINK_MORE"]["VALUE"]:"Подробнее"?></a>
								</div>
								<?
								if($i == 2 && $arResult["NEWS_IMAGE"]):
										$i++;							
										
								$img = CFile::GetFileArray($arResult["NEWS_IMAGE"]["PREVIEW_PICTURE"]);
								$img = CFile::ResizeImageGet($img, array("width" => 380,   "height" => ceil(380/$img["WIDTH"]*$img["HEIGHT"]) ), BX_RESIZE_IMAGE_EXACT, false, array());    								
										?>
										<div class="item item_image">
												<a href="<?=$arResult["NEWS_IMAGE"]["DETAIL_PAGE_URL"]?>">														
														<img class="some_img" src="<?=$img["src"]?>" alt="">
														<div class="b_title"><?=$arResult["NEWS_IMAGE"]["NAME"]?></div>
												</a>
										</div>										
										<?
								endif;								
						endforeach;
						?>
						<div class="clear"></div>
				</div>
		</div>
</div>	
<?endif;?>