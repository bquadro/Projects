<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
//$this->setFrameMode(true);

global $APPLICATION;
if (empty($arResult))
    return "";
if (count($arResult) < 1)
    return "";


$strReturn = '<div class="b_bread">';
$cnt = 0;
for ($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++) {
    #!isset($_REQUEST["brand"]) для вывода хлебных крошек при установленном бренде

    //if ($cnt)
    //    $strReturn .= "<span class='arrow'> /</span> ";

    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
				
    if ($arResult[$index]["LINK"] <> "")
        $_strReturn = '<a href="' . $arResult[$index]["LINK"] . '" title="' . $title . '" class="'.($index+1==$itemSize?"last":"").'">' . $title . '</a>';
    else
        $_strReturn = '<span class="'.($index+1==$itemSize?"last":"").'">' . $title . '</span>';
    
		//Сео ересь
		if ($arResult[$index]["LINK"] == $APPLICATION->GetCurPage() || $arResult[$index]["LINK"] == "/")
        $strReturn .= hideJS($_strReturn);		
		else
				$strReturn .= ($_strReturn);		
    $cnt++;
}
$strReturn .= '</div><div class="clear"></div>';

return $strReturn;
