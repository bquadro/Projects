<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
  
  //ФОРМА КЕШИРУЕТСЯ! НУЖНО СБРАСЫВАТЬ КЕШ ПРИ ИЗМЕНЕНИИ ПАРАМЕТРОВ ФОРМЫ
  
  if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
<?

if ($arResult["isFormNote"] == "Y")
{
?> 
<script>
$.fancybox.open([{content : '<h4 style="text-align:center;">Спасибо! Ваше сообщение отправлено.</h4>'}]);
</script>

<?
} //endif
?>
	
<?if ($arResult["isFormNote"] != "Y")
{
?>
<div class="b_form nopad">
<?=$arResult["FORM_HEADER"]?>
<?
if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
{
?>
<?
/***********************************************************************************
					form header
***********************************************************************************/
if ($arResult["isFormTitle"])
{
?>
	<h3 class="f24"><?=$arResult["FORM_TITLE"]?></h3>
<?
} //endif ;

	if ($arResult["isFormImage"] == "Y")
	{
	?>
	<a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>"><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" /></a>
	<?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
	<?
	} //endif
	?>

			<p><?=$arResult["FORM_DESCRIPTION"]?></p>

	<?
} // endif
	?>

<?
/***********************************************************************************
						form questions
***********************************************************************************/
?>

	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
	?>
      	<? if(  $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] =='textarea' ):?>
          <div class="b_block b_block_full">
      				<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
      				<span class="error-fld" title="<?=$arResult["FORM_ERRORS"][$FIELD_SID]?>"></span>
      				<?endif;?>
      				<label><?=$arQuestion["CAPTION"]?>&nbsp;<?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?></label>
      				<?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>
              <div class="b_input b_textarea"><?=$arQuestion["HTML_CODE"]?></div>
          </div>
        <?elseif( $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] =='hidden' ):?>
              <?=$arQuestion["HTML_CODE"]?>
              <script>$('form[name="SIMPLE_FORM_<?=$arResult['arForm']['ID'];?>"] input[name="form_hidden_<?=$arQuestion['STRUCTURE'][0]['ID'];?>"]').val() == 'N' ? $('form[name="SIMPLE_FORM_<?=$arResult['arForm']['ID'];?>"] input[name="form_hidden_<?=$arQuestion['STRUCTURE'][0]['ID'];?>"]').val('Y') : false;</script>
        <?else:?>
          <div class="b_block">
      				<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
      				<span class="error-fld" title="<?=$arResult["FORM_ERRORS"][$FIELD_SID]?>"></span>
      				<?endif;?>
      				<label><?=$arQuestion["CAPTION"]?>&nbsp;<?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?></label>
      				<?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>
              <div class="b_input"><?=$arQuestion["HTML_CODE"]?></div>
          </div>
        <?endif;?>
	<?
	} //endwhile
	?>
<?
  
if($arResult["isUseCaptcha"] == "Y")
{
?>
<div class="clear"></div>
<b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b><br>

<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" />

  <label><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></label><br><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="30" />
<div class="b_block">
  <div class="b_input"><input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /> </div>
</div>
<?
} // isUseCaptcha
?>
<div class="clear"></div>
<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> class="btn_140x40" type="submit" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />

<?=$arResult["FORM_FOOTER"]?>
</div>
<?
} //endif (isFormNote)
?>