<!doctype html>
<html lang="pt-br">
<head>
{:Head:}
</head>
<body>
	{TopBar}
	<div class="wrapper">
		<div class="body-container">
			<div class="default-container">
				<div class="leading-area">
					<div class="store-index-slideshow">
						<div class="slide-area"></div>
						<div class="control prev" onclick="javascript:ipe.slideShow.prevSlide()"><i class="fa fa-chevron-left"></i></div>
						<div class="control next" onclick="javascript:ipe.slideShow.nextSlide()"><i class="fa fa-chevron-right"></i></div>
					</div>
					<div class="store-leading-area-banners">
						<div class="up"><img src="[static]/images/todev.png"></div>
						<div class="bottom"><img src="[static]/images/wdev.png"></div>
					</div>
				</div>
				<div class="store-highlight-games-area">
					<h1 class="area-title">Games em destaque</h1>
					<ul class="games-display">
						{loop-HighLight-FirstFour}
						<li>
				
						  <div class="img-bg" style="background-image: url({-gameImage-});"> </div>
						  <span class="game-tag name">{-gameName-}</span>
						  {-gamePromoCode-}
						  <div class="game-tag price">{-priceCode-}</div>
						  <a class="a-overlay" href="[www]/g/{-gameId-}"></a>
						</li>
						{/loop-HighLight-FirstFour}

					</ul>
				</div>
				<div class="store-index-area-three">
					<div class="sub-showcase">
						<ul class="s-titles">
							<li data-js="showcasetab" data-tab-name="latest" class="current">Lançamentos</li>
							<li data-js="showcasetab" data-tab-name="topHit">Mais procurados</li>
							<li data-js="showcasetab" data-tab-name="soon">Em breve</li>
							<li data-js="showcasetab" data-tab-name="recom">Recomendados</li>
						</ul>
						<ul class="s-game-list latest visible"></ul>
						<ul class="s-game-list topHit"></ul>
						<ul class="s-game-list soon"></ul>
						<ul class="s-game-list recom"></ul>
					</div>
					<div class="s-banners">
						<div class="read-more">
							<span class="rm-text">
                    <i class="fa fa-info-circle"></i> Saiba mais sobre o projeto
                  </span>
						</div>
						<div class="get-linkr">
							<span class="rm-text">
                    <i class="fa fa-cloud-download"></i> Instale o Linkr
                    <span class="sub">(é gratis!)</span>
							</span>
						</div>
						<!--<div class="pub-banner"></div>-->
					</div>
				</div>
				<div class="store-last-updates-area">
					<h1 class="area-title">Atualizados recentemente</h1>
					<ul class="games-display">
						{loop-FourUpdates}
						<li>
							<div class="game-img">
								<img src="{-gameImage-}">
								<span class="game-tag name">{-gameName-}</span>
								<span class="game-tag price">R$ {-gamePrice-}</span>
							</div>
							<div class="update-description">
							  {-postPreview-}
							</div>
							<a class="a-overlay" href="[www]/g/{-gameId-}"></a>
						</li>
						{/loop-FourUpdates}
					</ul>
				</div>
			</div>
		</div>
{:Footer:}
	</div>
	<script src="[static]/scripts/linkr.store.index.js"></script>
	<script>
		var slideData = {jDataSlider};
		var	showcaseTabsData = {jDataShowcase};
		le.indexPage.init();
	</script>
</body>

</html>
