/*global $, alert, linkr, le */
var scpe = null;
le.scPage = {
	init: function () {
		scpe = le.scPage;
		if (le.shoppingCart.itemCount < 1) {
			window.location.href = "/";
		}
		$('.sc-page>.t-title').html('Carregando...');
		scpe.showResults();
	},
	removeGame: function (Id) {
		le.shoppingCart.removeGame(Id);
		$('#ciid_' + Id).fadeOut('slow', function () {
			$(this).remove();
			scpe.showResults();
		});

	},
	totalPrice: 0,
	checkout: function (toGift) {
		if (le.shoppingCart.itemCount > 0) {
			$.post('./checkout.php', {
					isGift: toGift,
					ids: le.shoppingCart.getGameIdList()
				},
				function (r) {
					window.location.href = "./checkout.html?buy=" + r;
				});
		} else {
			console.log('Nenhum jogo selecionado! :(');
			window.location.href = "./";
		}
	},
	showResults: function () {
		var games = le.shoppingCart.getData().gameList;
		$('.sc-page>.t-title').html('Seu carrinho de compras (' + le.shoppingCart.itemCount + (le.shoppingCart.itemCount == 1 ? ' item)' : ' itens)'));
		$('.sc-page>ul.game-list').html(' ');
		for (var g in games) {
			if (games[g] != null) {
				var gl = $('.sc-page>ul.game-list');
				var rs = games[g],

					li = document.createElement('li'),
					alink = document.createElement('a'),
					gameimg = document.createElement('div'),
					gamedata = document.createElement('div'),
					gametitle = document.createElement('div'),
					gamedevname = document.createElement('div'),
					gameprice = document.createElement('div'),
					gameoriginalprice = document.createElement('span'),
					gamediscount = document.createElement('div'),
					gamepriceclass = 'price',
					gameRmv = document.createElement('div'),
					grIcon = document.createElement('i');
				scpe.totalPrice += parseFloat(rs.price);
				gameimg.setAttribute('style', 'background-image: url(' + rs.img + ')');
				gameimg.setAttribute('class', 'game-img');

				gametitle.setAttribute('class', 'title');
				gametitle.appendChild(document.createTextNode(rs.name));

				gamedevname.setAttribute('class', 'devname');
				gamedevname.appendChild(document.createTextNode(rs.devname));


				gamedata.setAttribute('class', 'game-data');
				//for(var i = 0; i <15; i++){javascript:le.shoppingCart.addGame(i);}

				if (rs.withdiscount) {
					gameoriginalprice.setAttribute('class', 'original-price');
					gameoriginalprice.appendChild(document.createTextNode('R$ ' + rs.originalprice));

					gamediscount.setAttribute('class', 'discount');
					gamediscount.appendChild(document.createTextNode('-' + rs.percent + '%'));

					gamepriceclass += ' w-discount';
					gameprice.appendChild(gameoriginalprice);
					gameprice.appendChild(document.createElement('br'));
					gamedata.appendChild(gamediscount);
				}
				gameprice.setAttribute('class', gamepriceclass);
				gameprice.appendChild(document.createTextNode('R$ ' + rs.price.replace('.', ',')));
				gameRmv.setAttribute('class', 'rmv-game');
				gameRmv.setAttribute('onclick', 'javascript:scpe.removeGame(' + rs.id + ');return false;');
				grIcon.setAttribute('class', 'fa fa-times');
				gameRmv.appendChild(grIcon);

				gamedata.appendChild(gametitle);
				gamedata.appendChild(gameprice);
				gamedata.appendChild(gamedevname);

				li.appendChild(gameimg);
				li.appendChild(gamedata);
				li.appendChild(gameRmv);

				alink.setAttribute('href', '/g/' + rs.id);
				alink.appendChild(li);
				alink.setAttribute('id', 'ciid_' + rs.id);
				gl.append(alink);

			}
		}
		$(".sc-page>.total-bar>.price").html("R$ " + le.shoppingCart.totalPrice.toFixed(2).toString().replace('.', ','));

	}
};
