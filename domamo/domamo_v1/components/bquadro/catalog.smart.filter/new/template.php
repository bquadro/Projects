<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
		die();

//Правый фильтр
$this->SetViewTarget("area_filtr");

?>
<div class="r_filtr bx_filter">				
		<noindex>
		<form name="<?= $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter" id="rightFilter">		
				
			<?

			foreach($arResult["HIDDEN"] as $arItem):
				?><input type="hidden" name="<?= $arItem["CONTROL_NAME"]?>" id="<?= $arItem["CONTROL_ID"]?>" value="<?= $arItem["HTML_VALUE"]?>" /><?
			endforeach;
			
			$show_all = false;
			require	 "function.php";
			?>
		 <div class="clear"></div>
		  <div class="more_filtr_wrap">
  		  <div class="more_filtr_sticker">Это удобно<div class="mf-close"></div></div>
		    <a href="#full_filtr" class="more_filtr">Расширенный подбор</a> 
			</div>			
			<div class="bx_filter_button_box active">
				<div class="bx_filter_block">
					<div class="bx_filter_parameters_box_container">
							
						<input class="b_btn" type="submit" id="set_filter" name="set_filter" value="ПОКАЗАТЬ ПРОЕКТЫ" onclick="smart_filter_submit(this)" data-section-id="<?=$arResult['SECTION']['ID'];?>" data-iblock-id="<?=$arResult['SECTION']['IBLOCK_ID'];?>" />
						<?=hideJS("<a href='./' class='b_del_filtr'>Сбросить</a>")?>			
						<!-- <input class="bx_filter_search_reset" type="submit" id="del_filter" name="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" /> !-->
						
						<div class="bx_filter_popup_result <?=$arParams["POPUP_POSITION"]?>" id="modef" style="display:none">
								<div class="desc_modef">
										<span id="modef_num"><?$arResult["ELEMENT_COUNT"]?></span>
										<span id="modef_text" data-word1="Проект" data-word2="Проекта" data-word3="Проектов">Проектов</span>										
								</div>
								<div class="footer_modef">
										<a onclick="smart_filter_follow(this);" data-section-id="<?=$arResult['SECTION']['ID'];?>" data-iblock-id="<?=$arResult['SECTION']['IBLOCK_ID'];?>" href="<?echo $arResult["FILTER_URL"]?>" class="btn_140x40"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
								</div>
								<div class="b_arrow"></div>
								<div class="modef_close"></div>
						</div>
					</div>
				</div>
			</div>
			
			
		</form>			
		</noindex>
</div>
<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>');
</script>
<?
$this->EndViewTarget("area_filtr");

//Расширенный фильтр
$this->SetViewTarget("area_filtr_full");
?>
<div	class	=	"r_filtr">
		<noindex>
		<?
		$show_all = TRUE;
		require	 "function.php";
		?>		
		</noindex>
</div>
<hr>
<input class="b_btn" type="submit" id="set_filter" name="set_filter" value="ПОКАЗАТЬ ПРОЕКТЫ" onclick="smart_filter_submit(this);" data-section-id="<?=$arResult['SECTION']['ID'];?>" data-iblock-id="<?=$arResult['SECTION']['IBLOCK_ID'];?>" />
<?
$this->EndViewTarget("area_filtr_full")
?>