/* linkr.main.js */
/*global $, alert */
var le = {
	goToProfile: function (uname) {
		'use strict';
		window.location.href = '/u/' + uname;
	},
	goToGame: function (gname) {
		'use strict';
		window.location.href = '/g/' + gname;
	},
	info: {
		'logged': false,
		'username': ''
	},
	importScript: function (url, callback) {
		var script = document.createElement("script")
		script.type = "text/javascript";

		if (script.readyState) { //IE
			script.onreadystatechange = function () {
				if (script.readyState == "loaded" || script.readyState == "complete") {
					script.onreadystatechange = null;
					callback();
				}
			};
		} else { //Others
			script.onload = function () {
				callback();
			};
		}

		script.src = url + '.js';
		document.getElementsByTagName("head")[0].appendChild(script);
	},
	finalLoad: function(staticsURL) {
		le.statics = staticsURL;
		le.importScript(staticsURL + 'scripts/linkr.crypto', function () {});
		le.importScript(staticsURL + 'scripts/linkr.gritter', function () {});
	},
	statics: '',
	/*********************/
	// MODAL BOX! :D
	/*********************/
	modalBox: {
		show: function (title, url, frame) {
			$('body').addClass('modal-lock');

			var modal = document.createElement('div'),
				modalIt = document.createElement('div'),
				modalClose = document.createElement('div'),
				modalCloseIcon = document.createElement('i'),
				modalTitle = document.createElement('p'),
				modalBody = document.createElement('div');

			modalTitle.setAttribute('class', 'title');
			modalTitle.appendChild(document.createTextNode(title));

			modalClose.setAttribute('class', 'close');
			modalClose.setAttribute('onclick', 'javascript:le.modalBox.hide();');
			modalCloseIcon.setAttribute('class', 'fa fa-times');

			modalClose.appendChild(modalCloseIcon);

			modalBody.setAttribute('class', 'body');
			modalBody.appendChild(document.createTextNode('Carregando...'));

			modalIt.setAttribute('class', 'modal');
			modalIt.appendChild(modalClose);
			modalIt.appendChild(modalTitle);
			modalIt.appendChild(modalBody);

			modal.setAttribute('class', 'modal-overlay');
			modal.appendChild(modalIt);

			$('body').append(modal);


			$('.modal-overlay').fadeIn();
			if (frame !== true) {
				$.get(url, function (res) {
					//console.log(res);
					$('.modal-overlay>.modal>.body').html(res);
					$('.modal-overlay>.modal').css({
						width: ($('.modal-overlay>.modal>.body').outerWidth() + 10) + 'px'
					});
				});
			} else {
				var theFrame = document.createElement('iframe');
				theFrame.setAttribute('src', url);
				theFrame.setAttribute('frameBorder', '0');
				theFrame.setAttribute('width', '800px');
				theFrame.setAttribute('height', '500px');
				theFrame.setAttribute('style', 'margin: auto');
				$('.modal-overlay>.modal>.body').html('');
				$('.modal-overlay>.modal>.body').append(theFrame);
				$('.modal-overlay>.modal').css({
					width: ($('.modal-overlay>.modal>.body').outerWidth() + 10) + 'px'
				});
			}
			$(document).click(function (event) {
				cur_target = event.target;

				if ($(cur_target).closest($('.modal-overlay')).length && !$(cur_target).closest($('.modal')).length) {
					le.modalBox.hide();
				}
			});
		},
		hide: function () {
			$('.modal-overlay').fadeOut('fast', function () {
				$(this).remove();
				$('body').removeClass('modal-lock');
			});
		}
	},
	
	/*********************/
	// Login
	/*********************/
	postLogin: function (fromPage) {
		var uName, uPassEl;
		if (fromPage) {
			uNameEl = 'input[name=l-usr]';
			uPassEl = 'input[name=l-pwd]';
		}
		else {
			uNameEl = 'input[name=tb-usr]';
			uPassEl = 'input[name=tb-pwd]';
		}
		var uName = $(uNameEl).val(),
			uPass = le.crypto.hashPwd($(uPassEl).val());
		console.log("Nome: " + uName);
		console.log("Pass: " + uPass);

		$.post('/login/post', {
			'uidentity' : uName,
			'upwd'		: uPass
		}, function(res) {
			if(res.result == 'ok') {
				window.location.href = "/";
			}
			else if(res.result == '0') {
				if(fromPage) {
					$('#usr-i').addClass('error');
					$('#usr-p').addClass('error');
				}
				else {
					$('.the-login-box').addClass('error');
				}

			}
		});
	},
	
	/*********************/
	// Shopping Cart
	/*********************/
	shoppingCart: {
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
	}

};
$(document).ready(function () {
	'use strict';
	var cur_target;
	le.shoppingCart.init();
	$.post('/info', 
		{'ua': window.navigator.userAgent},
		function(res) {
			le.info = res;
		}
	);

	console.log("\n    _     _       _   \n" +
		"   | |   (_)     | |   \n" +
		"   | |    _ _ __ | | ___ __ \n" +
		"   | |   | | '_ \\| |/ / '__| \n" +
		"   | |___| | | | |   <| | \n" +
		"   |_____/_|_| |_|_|\\_\\_| \n\n");

	/****************
    	Hint boxes
  	*****************/
	$('[data-js*="hint"]').bind({
		// TODO: hint id
		mouseenter: function () {
			$(".hint").remove();
			var hint = document.createElement('div'),
				tset = document.createElement('div'),
				clss = $(this).attr('data-hint-class');
			tset.setAttribute('class', 'tset');

			hint.setAttribute('class', 'hint ' + (clss != undefined ? clss : ''));
			hint.appendChild(document.createTextNode($(this).attr('data-hint')));
			hint.appendChild(tset);

			$(document.body).append(hint);

			$(".hint").css({
				display: 'block',
				top: ($(this).offset().top - $(window).scrollTop() + $(this).height() + 2).toString() + 'px',
				left: ($(this).offset().left).toString() + 'px',
				'margin-left': ($(".hint").outerWidth() > $(this).outerWidth(true) ? (($(".hint").outerWidth() - $(this).outerWidth(true)) / 2 * -1) :
					(($(this).outerWidth(true) - $(".hint").outerWidth()) / 2)).toString() + 'px'
			});
		},
		mouseleave: function () {
			$(".hint").remove();
		},
		click: function () {
			$(".hint").remove();
		},
		blur: function () {
			$(".hint").remove();
		}
	});

	/****************
	 * Links ('cause href is for pussies)
	 ****************/
	$('[data-js*=goto]').on("click", function () {
		window.location = $(this).attr('data-goto');
	});

	/****************
    Input Focus
  *****************/
	$('.input input').on("focus", function () {
		$(this).parent().addClass('focused');
		if ($(this).parent().parent().hasClass('item-input')) {
			$(this).parent().parent().parent().addClass('focused');
		}
	});
	$('.input input').on("blur", function () {
		$(this).parent().removeClass('focused');
		if ($(this).parent().parent().hasClass('item-input')) {
			$(this).parent().parent().parent().removeClass('focused');
		}
	});


	/****************
    Modal Boxes
  *****************/
	$('[data-js*=modal-trigger]').on("click", function () {
		var mdl = $(this).attr('data-modal-url'),
			mdn = $(this).attr('data-modal-name'),
			mdf = $(this).attr('data-modal-iframe');
		le.modalBox.show(mdn, mdl, (mdf == 'true' ? true : false));
	});

	/*************************/

	$('.l-forg').on("click", function () {
		window.location.href = "/resetpassword";
	});

	/****************
    Dropdown Boxes
  *****************/

	$('[data-js*=dropdown]').on("focus click", function () {
		var bakin = $(this),
			sub = $(this).attr('data-dropdown');
		$('[data-js*="dropdown"]').each(function () {
			var suub = $(this).attr('data-dropdown');
			if (suub !== sub) {
				if ($(suub).is(":visible")) {
					$(this).removeClass('focused');
					$(suub).fadeOut('fast');
				}
			}
		});
		$(sub).fadeIn('fast');
		$(this).addClass('focused');
		return false;
	});

	$(document).click(function (event) {
		cur_target = event.target;
		$('[data-js*="dropdown"]').each(function () {
			var sub = $(this).attr('data-dropdown');
			if (!$(cur_target).closest(sub).length && !$(cur_target).closest($(this)).length) {
				if ($(sub).is(":visible")) {
					$(this).removeClass('focused');
					$(sub).fadeOut('fast');
				}
			}
		});
	});
});