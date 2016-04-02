<?
if	(!defined("B_PROLOG_INCLUDED")	||	B_PROLOG_INCLUDED	!==	true)
		die();
global	$curPage,	$USER;
$curPage	=	$APPLICATION->GetCurPage();



$APPLICATION->AddHeadScript("https://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru-RU");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/jquery.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/ui/jquery-ui-1.9.1.custom.min.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/ui/jquery.ui.touch-punch.min.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/jquery.fs.scroller.min.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/input.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/form.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/ion.rangeSlider.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/script.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/comparison.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/watchlist.js");


$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/fotorama/fotorama.js");
$APPLICATION->SetTemplateCSS(SITE_TEMPLATE_PATH."/js/fotorama/fotorama.css");					
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/tooltip/jquery.tooltipster.js");
$APPLICATION->SetTemplateCSS(SITE_TEMPLATE_PATH."/js/tooltip/tooltipster.css");				
				

$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH	.	"/js/fancybox/jquery.fancybox.js");
$APPLICATION->SetTemplateCSS(SITE_TEMPLATE_PATH."/js/fancybox/jquery.fancybox.css");			
CUtil::InitJSCore(array('ajax',	'window'));

?><!DOCTYPE html>
<html lang="ru">
		<head>            
				<title><?	$APPLICATION->ShowTitle()	?></title>         
				<link rel="icon" href="/favicon.ico" type="image/x-icon">
				<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"> 				
				<?	$APPLICATION->ShowHead()	?>    
				<link href="<?=	SITE_TEMPLATE_PATH	?>/css/adapt.css" rel="stylesheet" type="text/css" />
				<!--[if IE]>
				<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js "></script>
				<![endif]-->     
				<script type="text/javascript">var switchTo5x=true;</script>
				<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
				<script type="text/javascript">stLight.options({publisher: "fcff40c0-fbbc-42ca-bf0d-9916e8733d8d", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
</head>
<body>
<script>
//window.dataLayer = window.dataLayer || [];
</script>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KT7WJZ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KT7WJZ');</script>
<!-- End Google Tag Manager -->
<?	$APPLICATION->ShowPanel();	?>				
<header class="b_header">
	<div class="top_header">
			<div class="b_wrapper">
					<div class="city_select">
							<div class="city">Ваш город:</div>
							<div class="city_active">Москва</div>
							<ul class="top_header_ul">
									<li class="active msc" data-phone="+7 (495) 240 82 70, 8 (800) 200 28 83">Москва</li>
									<li class="spb" data-phone="+7 (812) 243 14 70, 8 (800) 200 28 83">Санкт-Петербург</li>
									<li class="nn" data-phone="+7 (831) 231-05-01, 8 (800) 200 28 83">Нижний Новгород</li>
							</ul>
					</div>
					<div class="tel">+7 (495) 240 82 70, 8 (800) 200 28 83</div>
					<a class="connect cell_form" href="#cell_form">Обратная связь</a>
					<!--
					<div class="social">
							<a class="twitter" href="#"></a>
							<a class="facebook" href="#"></a>
							<a class="youtube" href="#"></a>
							<a class="vk" href="#"></a>
					</div>
					
					<div class="b_search">
							<form action="/" method="post">
									<input type="text" class="search_text">
									<input type="submit" value="">
									<div class="title">Поиск: </div>
									<div class="placeholder">Поиск</div>
							</form>
					</div>
					!-->

					<div class="b_right">
							<a class="compare compare-head" href="/catalog/comparison/">Сравнить <span class="b_count"></span> <span class="b_count_text"></span></a>
							<a class="favorite favorite-head" href="/favorite/"><span>Избранное<span class="b_count_text"></span></span></a>
							<!--												
							<a class="profil" href="#">Мой профиль</a>
							!-->
					</div>
					<div class="clear"></div>
			</div>
	</div>
	<div class="header_two">
			<div class="b_wrapper">
					<?if($curPage != "/"):?>
							<a class="logo" href="/"><img src="/images/logo.png" alt="domamo.ru"></a>
					<?else:?>
							<div class="logo"><img src="/images/logo.png" alt="domamo.ru"></div>
					<?endif;?>						
          <div class="mini-cart-holder">
          
          </div>
					<div id="main-menu">
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"head_multilevel", 
	array(
		"ROOT_MENU_TYPE" => "top",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
			0 => "",
		),
		"MAX_LEVEL" => "3",
		"CHILD_MENU_TYPE" => "top_2",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);    
?>		
</div>		
										<div class="clear"></div>
								</div>
						</div>
				</header>				
				<main class="b_content <?	$APPLICATION->ShowProperty('ARTICLE_CLASS');	?>">   
						
				<?
				$page	=	$APPLICATION->GetCurPage();
				if($curPage != "/" && !preg_match("/\/(catalog)\//",	$page,	$arRes))	{
						$APPLICATION->IncludeComponent("bitrix:breadcrumb",	"main",	Array(),	false);	
				}
				$APPLICATION->IncludeFile(str_replace(".php",	".before.php",	$_SERVER["SCRIPT_NAME"]),	array(),	array("SHOW_BORDER"	=>	false));
				$APPLICATION->ShowProperty('_h1');
				?>
				<div class="b_content_2">

				

