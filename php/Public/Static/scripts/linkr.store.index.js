/*global $, alert, linkr, le */
// Index Page environment :D
var ipe = null;
function timeConverter(uts) {
	var t = new Date(uts * 1000);
	return (/*t.toLocaleTimeString() + ' ' + */t.toLocaleDateString());
}
le.indexPage = {
	init: function () {
		ipe = le.indexPage;
		ipe.fadeImgs();
		ipe.slideShow.start();
		ipe.sTabs.parseDataToContent();
		ipe.sTabs.watch();
	},
	slideShow: {
		currentSlide: 0,
		slideCount: 0,
		loadedSlides: 0,
		slideTimeout: null,
		preloadTimeout: null,
		startSlideTimeout: function () {
			clearTimeout(ipe.slideShow.slideTimeout);
			ipe.slideShow.slideTimeout = setTimeout(function () {
				ipe.slideShow.nextSlide();
			}, 5000);
		},
		preload: function () {
			if (ipe.slideShow.loadedSlides < ipe.slideShow.slideCount) {
				ipe.slideShow.preloadTimeout = setTimeout(function () {
					ipe.slideShow.preload();
				}, 500);
			} else {
				clearTimeout(ipe.slideShow.preloadTimeout);
				ipe.slideShow.currentSlide = 1;
				$('#sl_1').fadeIn('slow');
				ipe.slideShow.startSlideTimeout();
			}
		},
		start: function () {

			var d = slideData;
			if(d != null) 
			{
				for (var result in d) {
					ipe.slideShow.slideCount++;
					var rs = d[result],

						cgs = document.createElement('div'),
						alink = document.createElement('a'),
						gameimg = document.createElement('div'),
						gamedata = document.createElement('div'),
						gametitle = document.createElement('div'),
						gamedevname = document.createElement('div'),
						gameprice = document.createElement('div'),
						gameoriginalprice = document.createElement('span'),
						gamediscount = document.createElement('div'),
						gamepriceclass = 'cgs-price';

					gameimg.setAttribute('style', 'background-image: url(' + rs.image + ')');
					gameimg.setAttribute('class', 'cgs-image');

					gametitle.setAttribute('class', 'cgs-name');
					gametitle.appendChild(document.createTextNode(rs.name));

					gamedevname.setAttribute('class', 'devname');
					gamedevname.appendChild(document.createTextNode(rs.devname));


					gamedata.setAttribute('class', 'game-data');

					if (rs.soon) {
						gamepriceclass += ' soon';
						gameprice.appendChild(document.createTextNode('Em breve!'));
					} else if (rs.withdiscount == '1') {
						gameoriginalprice.setAttribute('class', 'original-price');
						gameoriginalprice.appendChild(document.createTextNode('R$ ' + rs.originalprice));

						gamediscount.setAttribute('class', 'cgs-discount');
						gamediscount.appendChild(document.createTextNode('-' + rs.percent + '%'));

						gamepriceclass += ' w-discount';
						gameprice.appendChild(gameoriginalprice);
						gameprice.appendChild(document.createElement('br'));
						gamedata.appendChild(gamediscount);
					}


					gameprice.setAttribute('class', gamepriceclass);
					if (!rs.soon) {
						gameprice.appendChild(document.createTextNode('R$ ' + rs.price.replace('.', ',')));
					}
					gamedata.appendChild(gametitle);
					gamedata.appendChild(gameprice);
					gamedata.appendChild(gamedevname);

					cgs.appendChild(gameimg);
					cgs.appendChild(gamedata);
					cgs.setAttribute('class', 'current-game-slide');
					cgs.setAttribute('id', 'sl_' + ipe.slideShow.slideCount);
					alink.setAttribute('href', '/g/' + rs.id);
					alink.appendChild(cgs);
					$('.store-index-slideshow>.slide-area').append(alink);
				}

				$('.current-game-slide>.cgs-image').each(function () {
					var wee = $(this),
						bgUrl = $(wee).css('background-image').replace('url(', '').replace(')', '').replace('"', '').replace('"', '');

					$(wee).html($('<img>').attr('src', bgUrl).load(function () {
						$(this).hide();
						//$(this).parent().parent().fadeIn('slow');
						$(this).parent().html('');
						ipe.slideShow.loadedSlides++;
					}));
				});

				ipe.slideShow.preload();
			}
		},
		prevSlide: function () {
			$('#sl_' + ipe.slideShow.currentSlide).fadeOut('slow');
			if (ipe.slideShow.currentSlide == 1) {
				ipe.slideShow.currentSlide = ipe.slideShow.slideCount;
			}
			ipe.slideShow.currentSlide--;
			$('#sl_' + ipe.slideShow.currentSlide).fadeIn('slow');

			ipe.slideShow.startSlideTimeout();
		},
		nextSlide: function () {

			$('#sl_' + ipe.slideShow.currentSlide).fadeOut('slow');
			if (ipe.slideShow.currentSlide == ipe.slideShow.slideCount) {
				ipe.slideShow.currentSlide = 0;
			}
			ipe.slideShow.currentSlide++;
			$('#sl_' + ipe.slideShow.currentSlide).fadeIn('slow');

			ipe.slideShow.startSlideTimeout();
		}
	},
	sTabs: {
		curTab : 'latest',
		parseDataToContent		:	function(){

			for(var tab in showcaseTabsData) {

				for(var game in showcaseTabsData[tab]) {
					var d = showcaseTabsData[tab][game],
							li = document.createElement('li'),
								imgGame = document.createElement('div'),
									theImg = document.createElement('img'),
								giTitle = document.createElement('div'),
								giGenre = document.createElement('div'),
									bGenre = document.createElement('b'),
								giRelease = document.createElement('div'),
									bRelease = document.createElement('b'),
								gamePrice = document.createElement('div'),
								aOverlay = document.createElement('a');

					theImg.setAttribute('src', d.img);
					imgGame.appendChild(theImg);
					imgGame.setAttribute('class', 'img-game');

					giTitle.setAttribute('class', 'game-info title');
					giTitle.appendChild(document.createTextNode(d.name));

					giGenre.setAttribute('class', 'game-info genre');
					bGenre.appendChild(document.createTextNode('Gênero: '));
					giGenre.appendChild(bGenre);
					giGenre.appendChild(document.createTextNode(d.genre));

					giRelease.setAttribute('class', 'game-info release');
					bRelease.appendChild(document.createTextNode('Lançamento: '));
					giRelease.appendChild(bRelease);
					giRelease.appendChild(document.createTextNode(timeConverter(d.releasedate)));

					gamePrice.setAttribute('class', 'game-price');
					gamePrice.appendChild(document.createTextNode((tab == 'soon' ? 'Em breve!' : 'R$ ' + d.price)));//(d.withdiscount ? 'R$ ' + (parseFloat(d.price) * (1 - parseFloat('0.' + d.percent))).toFixed(2).toString() : 'R$ ' + d.price))));

					aOverlay.setAttribute('class', 'a-overlay');
					aOverlay.setAttribute('href', '/g/' + d.id);

					li.appendChild(imgGame);
					li.appendChild(giTitle);
					li.appendChild(giGenre);
					li.appendChild(giRelease);
					li.appendChild(gamePrice);
					li.appendChild(aOverlay);

					$('.sub-showcase>.s-game-list.' + tab).append(li);

				}
			}

		},
		watch: function () {
			$('[data-js*="showcasetab"]').on("click", function () {
				var tab = $(this).attr('data-tab-name');
				if (ipe.sTabs.curTab != tab) {
					ipe.sTabs.changeTab(tab);
				}
			});
		},
		changeTab: function (tab) {
			$('.sub-showcase>.s-titles>.current').removeClass("current");
			$('[data-tab-name*="' + tab + '"]').addClass("current");

			$('.sub-showcase>.s-game-list.visible').removeClass("visible");
			$('.sub-showcase>.s-game-list.' + tab).addClass("visible");

			ipe.sTabs.curTab = tab;
		}
	},
	fadeImgs: function () {

		$('.img-bg').each(function () {
			$(this).hide();
			var bgUrl = $(this).css('background-image').replace('url(', '').replace(')', '').replace('"', '').replace('"', '');
			$(this).html($('<img>').attr('src', bgUrl).load(function () {
				$(this).hide();
				$(this).parent().fadeIn('slow', function () {
					$(this).css('transition', '0.3s ease-in-out');
					$(this).html('');
				});
			}));
		});
		(function () {

			$('.img-game>img').hide();
			$('.img-game>img').each(function (i) {
				if (this.complete) {
					$(this).fadeIn();
				} else {
					$(this).load(function () {
						$(this).fadeIn();
					});
				}
			});
		}());

	}
};
