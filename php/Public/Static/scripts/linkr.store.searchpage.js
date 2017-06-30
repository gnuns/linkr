/*global $, alert, linkr, le */
var spe = null;

function getURLParameter(name) {
	return decodeURI(
		(new RegExp(name + '=' + '(.+?)(&|$)').exec(location.search) || [, null])[1]
	);
}
le.searchPage = {
	init: function () {
		spe = le.searchPage;
		spe.searchQuery = getURLParameter('q');
		//alert(getURLParameter("q"));
		$('#thesearchinput').val(spe.searchQuery);
		$('.search-page>.t-title').html('Carregando...');
		spe.showResults();
	},
	searchQuery: '',
	realCount: 0,
	showMoreCount: 0,
	showResults: function () {
		$('.search-page>.o-load').remove();
		$.get('/search/query/' + spe.searchQuery +  '/offset/' + (spe.showMoreCount * 10) + '/json',
			function (data) {
				spe.showMoreCount++;
				var d = data,
						gl = $('.search-page>ul.game-list'),
						loadMoreButton = '<div class="load-and-post o-load" id="loadmore"><div class="load-more" onclick="spe.showResults()">Ver mais resultados</div></div>';
				if(spe.realCount == 0) {
						spe.realCount = d['results.total'];
						$('.search-page>.t-title').html('Sua pesquisa retornou <b>'+d['results.total']+'</b> resultados');
				}
				for(var result in d['results']) {
					var rs = d['results'][result],

							li = document.createElement('li'),
								alink = document.createElement('a'),
								gameimg = document.createElement('div'),
								gamedata = document.createElement('div'),
									gametitle = document.createElement('div'),
									gamedevname = document.createElement('div'),
									gameprice = document.createElement('div'),
									gameoriginalprice = document.createElement('span'),
									gamediscount = document.createElement('div'),
									gamepriceclass = 'price';
					gameimg.setAttribute('style', 'background-image: url('+rs.bgimg+')');
					gameimg.setAttribute('class', 'game-img');

					gametitle.setAttribute('class', 'title');
					gametitle.appendChild(document.createTextNode(rs.name));

					gamedevname.setAttribute('class', 'devname');
					gamedevname.appendChild(document.createTextNode(rs.devname));


					gamedata.setAttribute('class', 'game-data');


					if(rs.withdiscount == '1') {
						gameoriginalprice.setAttribute('class', 'original-price');
						gameoriginalprice.appendChild(document.createTextNode( 'R$ ' +  rs.originalprice ));

						gamediscount.setAttribute('class', 'discount');
						gamediscount.appendChild(document.createTextNode('-' + rs.percent + '%'));

						gamepriceclass += ' w-discount';
						gameprice.appendChild(gameoriginalprice);
						gameprice.appendChild(document.createElement('br'));
						gamedata.appendChild(gamediscount);
					}
					gameprice.setAttribute('class', gamepriceclass);
					gameprice.appendChild(document.createTextNode('R$ '+  rs.price.replace('.', ',')));
					gamedata.appendChild(gametitle);
					gamedata.appendChild(gameprice);
					gamedata.appendChild(gamedevname);

					li.appendChild(gameimg);
					li.appendChild(gamedata);
					li.setAttribute('onclick', 'javascript:le.goToGame('+rs.id+');');
					alink.setAttribute('href', '/g/' + rs.id);
					alink.setAttribute('id', 'sr_'+ rs.id);
					alink.appendChild(li);
					gl.append(alink);
				}

				if((spe.showMoreCount * 10) < spe.realCount) {
					$('.search-page').append(loadMoreButton);
				}

			}
		);
	}
};
