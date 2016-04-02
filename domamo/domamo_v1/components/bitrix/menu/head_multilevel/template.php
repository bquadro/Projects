<?	
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)	die();		

if	(!empty($arResult)):	
		?><ul class="main_menu_ul"><?
		$previousLevel	=	0;
		foreach	($arResult	as	$arItem):
				
				if	($previousLevel	&&	$arItem["DEPTH_LEVEL"]	<	$previousLevel):	
						echo	str_repeat("</ul></li>",	($previousLevel	-	$arItem["DEPTH_LEVEL"]));
				endif;
										
				if	($arItem["DEPTH_LEVEL"]	==	1):	
						$name = $arItem["TEXT"];
						//на 1000px скрывается слово "проекты"
						if($arItem["TEXT"] != "Проекты домов" && preg_match("/^(Проекты)[\s]/i",	$arItem["TEXT"], $arRes)){								
								$arItem["TEXT"] = str_replace("Проекты",	"<span>Проекты</span>",	$arItem["TEXT"]);
						}

						$link = '<a href="'.$arItem["LINK"].'" class="main_menu_a '.($arItem["SELECTED"]?"active":"").'">'.$arItem["TEXT"].'</a>';
						if( $arItem["LINK"] == $APPLICATION->GetCurPage() ){
								$link = hideJS($link);									
						}
						?>
						<li class="main_menu_li"><?=$link?>				
						<?
						if($arItem["PARAMS"]["FILE"]!="" && is_file($_SERVER["DOCUMENT_ROOT"]."/include/".$arItem["PARAMS"]["FILE"]) ){								
								$APPLICATION->IncludeFile("/include/".$arItem["PARAMS"]["FILE"],	array(),	array("SHOW_BORDER"	=>	true, "NAME"=>"меню '".$name."'", "MODE"=>"text"));
						};
				else:
						$link = '<a href="'.$arItem["LINK"].'">'.$arItem["TEXT"].'</a>';
						if( $arItem["LINK"] == $APPLICATION->GetCurPage() ){
								$link = hideJS($link);									
						}						
						?><li <?	if	($arItem["SELECTED"]):	?> class="item-selected"<?	endif	?>><?=$link?><?
				endif;
				
				echo $arItem["IS_PARENT"]?"<ul>":"</li>";												
				$previousLevel	=	$arItem["DEPTH_LEVEL"];
				
		endforeach;
		if	($previousLevel	>	1):
				echo 	str_repeat("</ul></li>",	($previousLevel	-	1));
		endif	
		?></ul><?
endif
?>