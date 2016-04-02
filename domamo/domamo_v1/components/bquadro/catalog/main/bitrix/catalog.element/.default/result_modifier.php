<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
		die();

CModule::IncludeModule("iblock");

//Информация о компании
$arResult["COMPANY"] = false;
if($arResult["PROPERTIES"]["COMPANY"]["VALUE"]){
		$arFilter	=	Array("IBLOCK_ID"	=>	IBLOCK_COMPANY,	"ACTIVE_DATE"	=>	"Y",	"ACTIVE"	=>	"Y", "ID"=>$arResult["PROPERTIES"]["COMPANY"]["VALUE"]);
		$res	=	CIBlockElement::GetList(Array(),	$arFilter, false);
		if	($ob	=	$res->GetNextElement())	{
				$arFields	=	$ob->GetFields();
				$arFields["PROPERTIES"] = $ob->GetProperties();												
				if($arFields["PREVIEW_PICTURE"]){
						$logo = CFile::GetFileArray($arFields["PREVIEW_PICTURE"]);

						if( (75/$logo["HEIGHT"]*$logo["WIDTH"]) > 120){								
								$logo =  CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array("width" => 120,   "height" => 75), BX_RESIZE_IMAGE_PROPORTIONAL_ALT , false, array());         						
						} else {
								$logo =  CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array("width" => 75/$logo["HEIGHT"]*$logo["WIDTH"],   "height" => 75), BX_RESIZE_IMAGE_EXACT, false, array());         
						}
						$arFields["PREVIEW_PICTURE"] = $logo["src"];
				}
				$arResult["COMPANY"] = $arFields;			
		}
}

//Материалы
$HLB_MATERIAL = 2;

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

$hlblock = HL\HighloadBlockTable::getById($HLB_MATERIAL)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$main_query = new Entity\Query($entity);
$main_query->setSelect(array('*'));
$result = $main_query->exec();
$result = new CDBResult($result);

$rows = array();
while ($row = $result->Fetch()){
		$row["ICO"] = CFile::GetByID($row["UF_FILE"]);
		$rows[$row["UF_XML_ID"]] = $row;
}
$arResult["MATERIAL"] = $rows;


//Подсказки к характеристикам
CModule::IncludeModule("iblock");
$arEnumDop = false;
$sql = "SELECT  * FROM `bq_property_param_enum`	";
$res = $DB->Query($sql);
while($resultEnum = $res->Fetch()){
		$arEnumDop[$resultEnum["ENUM_ID"]] = $resultEnum;																				
}		

$arEnum = false;
$sql = "SELECT  * FROM `bq_property_param`	";
$res = $DB->Query($sql);
while($result = $res->Fetch()){
		$arEnum[$result["PROP_ID"]] = $result;																				
}		

foreach($arResult["PROPERTIES"] as $key=>$arItem):		
		if($arItem["PROPERTY_TYPE"] == "F"){
				continue;
		}
				
		$arResult["PROPERTIES"][$key]["SHOW_MAIN"] = (int)$arEnum[ $arItem["ID"] ] ["DOP_FILTR"] == 0 ? "N":"Y";
		$arResult["PROPERTIES"][$key]["DESCRIPTION"] = false;
		if(isset($arEnum[$arItem["ID"]])){
				
				$tmp = $arEnum[$arItem["ID"]];
				
				$arResult["PROPERTIES"][$key]["DESCRIPTION"] = $tmp["DESCRIPTION_TYPE"]!="html"?nl2br($tmp["DESCRIPTION"]):$tmp["DESCRIPTION"];
				$arResult["PROPERTIES"][$key]["DESCRIPTION"] = $arResult["PROPERTIES"][$key]["DESCRIPTION"]==""?false:$arResult["PROPERTIES"][$key]["DESCRIPTION"];
				if($arResult["PROPERTIES"][$key]["DESCRIPTION"]){
							$arResult["PROPERTIES"][$key]["DESCRIPTION"] = "<div class=\"b_name\">{$arResult["PROPERTIES"][$key]["NAME"]}</div>".$arResult["PROPERTIES"][$key]["DESCRIPTION"];
							$arResult["PROPERTIES"][$key]["DESCRIPTION"] = str_replace('"',	"'",	$arResult["PROPERTIES"][$key]["DESCRIPTION"]);
				}				

				if($arItem["PROPERTY_TYPE"] != "L"){
  				
				  if($key == "AREA1"){
            $area2 = $arResult["PROPERTIES"]['AREA2']["VALUE"];
        		$area1 = $arResult["PROPERTIES"][$key]["VALUE"];
        		$arResult["PROPERTIES"][$key]["VALUE"] = $area1 != "" && $area2 != "" ? $area1."/".$area2 : $area1;
  				}

					if(isset($tmp["UNITS"]) && $tmp["UNITS"] && $arResult["PROPERTIES"][$key]["VALUE"]!='' ){
						$arResult["PROPERTIES"][$key]["VALUE"] = $arResult["PROPERTIES"][$key]["VALUE"].' '.$tmp["UNITS"];
					}
				}
	
				if($arItem["PROPERTY_TYPE"] == "L"){
						//var_dump($arItem);
          					//	  var_dump( $arResult["PROPERTIES"][$key]["VALUE"]);
          					//	  var_dump( $arResult["PROPERTIES"][$key]["NAME"]);
          		
           $is_checkbox = $arResult["PROPERTIES"][$key]["VALUE"][0] == $arResult["PROPERTIES"][$key]["NAME"]	;
          					
						foreach($arItem["VALUE_ENUM_ID"] as $k=>$val){
								$t = false;
								if(isset($arEnumDop[$val])){
										
										$t = $arEnumDop[$val]["DESCRIPTION_TYPE"]!="html"?nl2br($arEnumDop[$val]["DESCRIPTION"]):$arEnumDop[$val]["DESCRIPTION"];
										$t = $t==""?false:$t;
										if($t){
												$t = "<div class=\"b_name\">{$arResult["PROPERTIES"][$key]["VALUE"][$k]}</div>".$t;
												$t = str_replace('"',	"'",	$t);
										}
										
          					if(isset($tmp["UNITS"]) && $tmp["UNITS"] && $arResult["PROPERTIES"][$key]["VALUE"][$k]!='' ){
          						$arResult["PROPERTIES"][$key]["VALUE"][$k] = $arResult["PROPERTIES"][$key]["VALUE"][$k].' '.$tmp["UNITS"];
          					}
										
            				if($is_checkbox)
          						 $arResult["PROPERTIES"][$key]["VALUE"][0] = "Есть";			
                    //подсказка для каждого значения поля
										if(!$is_checkbox && $t) //когда это не чекбокс
										  $arResult["PROPERTIES"][$key]["VALUE"][$k] = '<div class="b_value_text">'.$arResult["PROPERTIES"][$key]["VALUE"][$k].'</div><div class="q" data-text="'.$t.'" ></div>';
										elseif($t) //подсказка для названия поля, когда это чекбокс
										  $arResult["PROPERTIES"][$key]["DESCRIPTION"] = $t;		
								} 
						}		
				}
		}
endforeach;


//.var_dump($arResult["MATERIAL"]);
//Группировка технических характеристик 
for($i=1;$i<=2;$i++):
		$arResult["TECH_".$i] = false;
		foreach	($arParams["DETAIL_PROPERTY_TECH_".$i] as $code){
    		if($code == "AREA2")
    				continue;
				if(!$arResult["PROPERTIES"][$code]["VALUE"])
						continue;
				if($code == "MATERIAL"){
						foreach	($arResult["PROPERTIES"][$code]["VALUE"]  as $k=>$v){
								$arResult["PROPERTIES"][$code]["VALUE"][$k] = $arResult["MATERIAL"][ $v ]["UF_NAME"];
						}						
				}

				if(is_array($arResult["PROPERTIES"][$code]["VALUE"])){	
				  $arResult["PROPERTIES"][$code]["VALUE"] = '<div class="b_value_item">'. implode("</div><div class=\"b_value_item np\">,</div><div class=\"b_value_item\">",	$arResult["PROPERTIES"][$code]["VALUE"]).'</div>';		
				}else 
				if($arResult["PROPERTIES"][$code]["VALUE"] == $arResult["PROPERTIES"][$code]["NAME"]){
  				$arResult["PROPERTIES"][$code]["VALUE"] = '<div class="b_value_item">Есть</div>';
				} else {
  				$arResult["PROPERTIES"][$code]["VALUE"] = '<div class="b_value_item">'.$arResult["PROPERTIES"][$code]["VALUE"].'</div>';
				}

				$arResult["TECH_".$i][] = $arResult["PROPERTIES"][$code];
		}
endfor;
