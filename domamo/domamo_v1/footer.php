<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
		die();
global $curPage, $USER;
IncludeTemplateLangFile(__FILE__);
$APPLICATION->IncludeFile(str_replace(".php",	".after.php",	$_SERVER["SCRIPT_NAME"]),	array(),	array("SHOW_BORDER"	=>	false));
?> 
				</div>
		</main>
		
		<footer class="footer">
				<div class="b_wrapper">		
						<nav class="area_links">																
								<div class="item item_1">
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"footer", 
	array(
		"ROOT_MENU_TYPE" => "footer_1",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
			0 => "",
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
					"BLOCK_NAME"=> "Проекты",
					"BLOCK_COUNT" => 2,
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);    
?>													
								</div>
								<div class="item item_2">
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"footer", 
	array(
		"ROOT_MENU_TYPE" => "footer_2",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
			0 => "",
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
					"BLOCK_NAME"=> "Популярное",
					"BLOCK_COUNT" => 2,
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);    
?>											
								</div>
								<div class="item item_3">
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"footer", 
	array(
		"ROOT_MENU_TYPE" => "footer_3",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"BLOCK_NAME" => "Как заказать?",
		"BLOCK_COUNT" => "1"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);    
?>														
								</div>
								<div class="item item_4">
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"footer", 
	array(
		"ROOT_MENU_TYPE" => "footer_4",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"BLOCK_NAME" => "Партнерам",
		"BLOCK_COUNT" => "1"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);    
?>											
								</div>
								<div class="item item_5">
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"footer", 
	array(
		"ROOT_MENU_TYPE" => "footer_5",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
			0 => "",
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
					"BLOCK_NAME"=> "О компании",
					"BLOCK_COUNT" => 1,
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);    
?>													
								</div>
								<div class="clear"></div>
						</nav>

								
						<div class="footer_bottom_line">
								<span class="copy">&copy;2015 «Domamo»</span>
								<div class="city_select">
										<div class="city_active">Москва</div>
										<ul class="top_header_ul">
												<li class="active msc" data-phone="+7 (495) 240 82 70, 8 (800) 200 28 83">Москва</li>
												<li class="spb" data-phone="+7 (812) 243 14 70, 8 (800) 200 28 83">Санкт-Петербург</li>
												<li class="nn" data-phone="+7 (831) 231-05-01, 8 (800) 200 28 83">Нижний Новгород</li>
										</ul>
								</div>
								<div class="contackt">
										<span class="tel">+7 (495) 240 82 70, 8 (800) 200 28 83</span>
										<a class="connect cell_form" href="#cell_form">Обратная связь</a>
								</div>
								<!--
								<div class="social">
										<a class="twitter" href="#"></a>
										<a class="facebook" href="#"></a>
										<a class="youtube" href="#"></a>
										<a class="vk" href="#"></a>
								</div>!-->
								<div class="card_block">
										<a class="visa" href="/sposoby-oplaty/"></a>
										<a class="master" href="/sposoby-oplaty/"></a>
								</div>
								<!--
								<div class="b_search">
										<form action="/" method="post">
												<input type="text" class="search_text">
												<input type="submit" value="">
												<div class="title">Поиск: </div>
												<div class="placeholder">Поиск</div>
										</form>
								</div>
								!-->
								<?if ($curPage == "/"): ?>
												<div class="developed"><a href="http://bquadro.ru/" target="_blank"><span>Разработано<span class="hide_1300"> с любовью в</span></span></a> <img src="<?=SITE_TEMPLATE_PATH?>/images/bquadro.png" alt="bquadro"></div>
								<?else:?>
													<div class="developed"><span>Разработано<span class="hide_1300"> с любовью в</span></span> <a href="http://bquadro.ru/" target="_blank"> <img src="<?=SITE_TEMPLATE_PATH?>/images/bquadro.png" alt="bquadro"></a></div>
								<?endif;?>        								
								<!-- <a class="developed" href="http://bquadro.ru/" target="_blank"><span>Разработано<span class="hide_1300"> с любовью в</span></span></a>!-->
						</div>
						<div class="clear"></div>
				</div>
		</footer>
		
		<?= $APPLICATION->AddBufferContent("showHideJS"); ?>

<!-- google analitycs -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-61250581-1', 'auto'); ga('send', 'pageview');
ga('require', 'ecommerce');
</script>
<!-- /google analitycs -->
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter29322070 = new Ya.Metrika({
                    id:29322070,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    ecommerce:"dataLayer"
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/29322070" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>

<?
if (!strlen(trim($APPLICATION->GetProperty('H1')))) {
    $APPLICATION->SetPageProperty('H1', $APPLICATION->GetTitle());
};
if ($APPLICATION->GetProperty('SHOW_H1') != 'N') {
    $APPLICATION->SetPageProperty('_h1', '<h1 class="title_page">' . $APPLICATION->GetProperty('h1') . '</h1>');
};

if (strlen(trim($APPLICATION->GetProperty('ARTICLE_CLASS'))) == 0) {
		$APPLICATION->SetPageProperty('ARTICLE_CLASS', $APPLICATION->GetProperty('ARTICLE_CLASS') . " b_dop_content");
}

$page	=	$APPLICATION->GetCurPage();
if	(CHTTP::GetLastStatus()	==	"404 Not Found"	&&	$page	!=	"/404.php")	{

		if	(preg_match("/\/(.*?)[^\/]$/i",	$page,	$arRes))	{
				LocalRedirect($arRes[0]	.	"/");
				die();
		}
		$APPLICATION->RestartBuffer();
		echo	file_get_contents("http://"	.	$_SERVER["SERVER_NAME"]	.	"/404.php?404=N");		
		die();
}
