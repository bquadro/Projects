<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (is_array($arResult["RESULT"]) && isset($arResult['RESULT']['TRANSIT_CDEK']))
{
	/*if ($arResult["RESULT"]["RESULT"] == "NEXT_STEP")
		require("step.php");
	else
	{*/
		if ($arResult["RESULT"]["RESULT"] == "OK")
		{
			if ($arResult["RESULT"]["TRANSIT_CDEK"] > 0)
			{
				echo GetMessage('SALE_SADC_TRANSIT').': <b>'.$arResult["RESULT"]["TRANSIT_CDEK"].'</b>';
			}
		}
	//}
}

/*if ($arParams["STEP"] == 0)
	require("start.php");*/
?>