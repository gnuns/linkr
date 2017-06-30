/* linkr.store.main.js */
/*global $, alert */
	/*********************/
	// Shopping Cart
	/*********************/
var shoppingCart = {
	pay: function () {
		window.location.href = './shopping-cart.html';
	},
	isSet: function () {
		return localStorage.getItem("linkr-cart") ? true : false;
	},
	getData: function () {
		return JSON.parse(localStorage.getItem("linkr-cart"));
	},
	setData: function (obj) {
		localStorage.setItem('linkr-cart', JSON.stringify(obj));
	},
	getGameIdList: function () {
		var games = le.shoppingCart.getData().gameList,
			list = new Array();
		for (var g in games) {
			if (games[g] != null) {
				list.push(games[g].id);
			}
		}
		return JSON.stringify(list);
	},
	gameIsIn: function (gameId) {
		return (this.getData().gameList[gameId] == null) ? false : (this.getData().gameList[gameId].price == null ? false : true);
	},
	addGame: function (id) {
		if (!le.shoppingCart.gameIsIn(id)) {
			$.get('get.php?gameData=' + id, function (game) {
				var a = le.shoppingCart.getData();
				a.gameList[id] = game;
				le.shoppingCart.setData(a);

				le.shoppingCart.refresh();

			});
		}
	},
	removeGame: function (id) {
		var a = le.shoppingCart.getData();
		a.gameList[id] = null;
		le.shoppingCart.setData(a);
		le.shoppingCart.refresh();
	},
	refresh: function () {
		le.shoppingCart.totalPrice = 0;
		le.shoppingCart.itemCount = 0;

		var games = le.shoppingCart.getData().gameList;
		$("#s-cart-box>ul.game-list").html('');
		for (var g in games) {
			if (games[g] != null) {
				le.shoppingCart.itemCount++;

				var game = games[g],
					li = document.createElement('li'),
					gameImg = document.createElement('div'),
					gameData = document.createElement('div'),
					gameTitle = document.createElement('div'),
					gamePrice = document.createElement('div'),
					gameRmv = document.createElement('div'),
					grIcon = document.createElement('i');

				le.shoppingCart.totalPrice += parseFloat(game.price);

				gameImg.setAttribute('class', 'game-img');
				gameImg.setAttribute('style', 'background-image: url(' + game.img + ');');
				gameTitle.setAttribute('class', 'title');
				gameTitle.appendChild(document.createTextNode(game.name));

				gameData.setAttribute('class', 'game-data');
				gameData.appendChild(gameTitle);

				if (game.withdiscount) {
					gamePrice.setAttribute('class', 'price w-discount');
					var originalPrice = document.createElement('span'),
						gameDiscount = document.createElement('div');

					gameDiscount.setAttribute('class', 'discount');
					gameDiscount.appendChild(document.createTextNode('-' + game.percent + '%'));

					originalPrice.setAttribute('class', 'original-price');
					originalPrice.appendChild(document.createTextNode('R$ ' + game.originalprice.toString().replace('.', ',')));

					gamePrice.appendChild(originalPrice);
					gamePrice.appendChild(document.createElement('br'));


					gameData.appendChild(gameDiscount);

				} else {
					gamePrice.setAttribute('class', 'price');

				}
				gamePrice.appendChild(document.createTextNode('R$ ' + (game.price).toString().replace('.', ',')));

				gameData.appendChild(gamePrice);

				gameRmv.setAttribute('class', 'rmv-game');
				gameRmv.setAttribute('onclick', 'javascript:le.shoppingCart.removeGame(' + game.id + ');');
				grIcon.setAttribute('class', 'fa fa-times');
				gameRmv.appendChild(grIcon);

				li.appendChild(gameImg);
				li.appendChild(gameData);
				li.appendChild(gameRmv);

				gameData.setAttribute('onclick', 'javascript:le.goToGame(' + game.id + ');');

				$("#s-cart-box>ul.game-list").append(li);
			}
		}

		$(".shopping-cart>.shopping-cart-items").text(le.shoppingCart.itemCount);
		if (le.shoppingCart.itemCount > 0) {
			$(".shopping-cart>.shopping-cart-items").fadeIn();
			$(".shopping-cart-box>.total-price>.price").html("R$ " + le.shoppingCart.totalPrice.toFixed(2).toString().replace('.', ','));
			$(".shopping-cart-box>.total-price").show();
		} else {
			$(".shopping-cart>.shopping-cart-items").fadeOut();
			$(".shopping-cart-box>.total-price").hide();
		}
	},
	totalPrice: 0,
	itemCount: 0,
	init: function () {
		if (!this.isSet()) {
			var cart = {
				'gameList': {}
			};

			le.shoppingCart.setData(cart);
		}
		le.shoppingCart.refresh();
	}
};