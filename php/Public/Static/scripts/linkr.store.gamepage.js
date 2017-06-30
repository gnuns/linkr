/*global $, alert, linkr, le */
// Game page environment :D
var gpe = null;

function ytId(url) {
	var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
	var match = url.match(regExp);
	if (match && match[7].length == 11) {
		return match[7];
	} else {
		return '';
	}
}


function timeConverter(uts) {
	var t = new Date(uts * 1000);
	return (t.toLocaleTimeString() + ' ' + t.toLocaleDateString());
}


le.gamePage = {
	init: function () {
		gpe = le.gamePage;
		this.mTabs.loadMedia();
		this.mTabs.watch();
		this.mReviews.init();
	},

	mReviews: {
		reviewCount: 0,
		reviewsTotal: 0,
		init: function () {
			gpe.mReviews.loadMore(iniReviewData, true);
		},
		loadMore: function (data, isJsonInput) {
			$('.reviews>.reviews-load-and-post>.load-more').remove();
			if (!isJsonInput) {
				var loading = '<div class="visible" id="loadingthisarea" style="margin:auto;margin-top:15px;margin-bottom:30px;width:150px;text-align:center;font-family:Strait,Droid Sans,MyriadPro,Arial,sans-serif;font-size:28px;display:none;">Carregando...</div>';
				$('.reviews>.review-list').append(loading);

				$('#loadingthisarea').fadeIn('slow');

				$.get("./get.php?reviews&curcount=" + gpe.mReviews.reviewCount + "&game=thisgmae", function (data) {
					gpe.mReviews.loadMore(data, true);
				});
			} else {
				var d = data['reviews'],
					rl = '.reviews>.review-list',
					n = 0;
				gpe.mReviews.reviewsTotal = data['reviews.total'];
				for (var rvw in d) {
					var cr = d[rvw],
						review = document.createElement('div'),

						therev = document.createElement('div'),

						revinfo = document.createElement('div'),

						revtype = document.createElement('div'),

						ticon = document.createElement('i'),

						revdate = document.createElement('div'),

						revaudience = document.createElement('div'),

						stars = document.createElement('p'),

						sicon = document.createElement('i'),

						comments = document.createElement('p'),

						cicon = document.createElement('i'),

						revcontent = document.createElement('div'),

						revauthorinfo = document.createElement('div'),

						ainamenphoto = document.createElement('div'),

						aiphoto = document.createElement('img'),

						ainame = document.createElement('p'),

						airank = document.createElement('div'),

						aiactivity = document.createElement('div'),

						aigames = document.createElement('p'),

						aireviews = document.createElement('p'),

						aiforumposts = document.createElement('p'),

						revfavbutton = document.createElement('p'),

						ficon = document.createElement('i');

					/****/ //revaudience
					//stars.setAttribute('onclick', 'javascript:gpe.mReviews.whoFavedBox(' + cr.id + ')');
					sicon.setAttribute('class', 'fa fa-star');
					stars.appendChild(sicon);
					stars.appendChild(document.createTextNode(cr.info.stars));

					//comments.setAttribute('onclick', 'javascript:gpe.mReviews.commentsBox(' + cr.id + ')');
					//cicon.setAttribute('class', 'fa fa-comments-o');
//					comments.appendChild(cicon);
//					comments.appendChild(document.createTextNode(cr.info.comments));

					revaudience.setAttribute('class', 'review-audience');
					revaudience.appendChild(stars);
//					revaudience.appendChild(comments);

					/****/ //revdate
					revdate.appendChild(document.createTextNode(timeConverter(cr.info.date)));
					revdate.setAttribute('class', 'review-date');

					/****/ //revtype
					revtype.setAttribute('class', 'review-type');
					var typeText = cr.info.type == 'up' ? 'Análise Positiva' : 'Análise Negativa';
					ticon.setAttribute('class', 'fa fa-thumbs-' + cr.info.type);

					revtype.appendChild(document.createTextNode(typeText + ' '));
					revtype.appendChild(ticon);

					/**/ //revinfo

					revinfo.setAttribute('class', 'review-info');
					revinfo.appendChild(revtype);
					revinfo.appendChild(revdate);
					revinfo.appendChild(revaudience);

					/**/ //revcontent
					revcontent.setAttribute('class', 'review-content');
					revcontent.appendChild(document.createTextNode(cr.content + ' '));

					/**/ //therev
					therev.setAttribute('class', 'the-review');
					therev.appendChild(revinfo);
					therev.appendChild(revcontent);

					/**/ //revauthorinfo

					aiphoto.setAttribute('src', cr.author.avatar);
					aiphoto.setAttribute('rel', cr.author.name);

					ainame.setAttribute('class', 'a-name');
					ainame.appendChild(document.createTextNode(cr.author.name));

					ainamenphoto.setAttribute('class', 'a-name-and-photo');
					ainamenphoto.setAttribute('onclick', 'javascript:le.goToProfile(\'' + cr.author.sname + '\');');
					var rmvGame
					ainamenphoto.appendChild(aiphoto);
					ainamenphoto.appendChild(ainame);

					airank.setAttribute('class', 'user-rank-strip ' + cr.author.rank);
					if (cr.author.rank == 'dev') {
						airank.appendChild(document.createTextNode('Desenvolvedor'));
					} else if (cr.author.rank == 'gamer') {
						airank.appendChild(document.createTextNode('Gamer'));
					} else if (cr.author.rank == 'member') {
						airank.appendChild(document.createTextNode('Membro'));
					}

					aiactivity.setAttribute('class', 'activity-info');
					var ai_gs = document.createElement('p'),
						ai_gsn = document.createElement('b'),
						ai_rs = document.createElement('p'),
						ai_rsn = document.createElement('b'),
						ai_ps = document.createElement('p'),
						ai_psn = document.createElement('b');
					ai_gsn.appendChild(document.createTextNode(cr.author.activity.games));
					ai_rsn.appendChild(document.createTextNode(cr.author.activity.reviews));

					ai_gs.appendChild(ai_gsn);
					ai_gs.appendChild(document.createTextNode(' Jogos na conta'));

					ai_rs.appendChild(ai_rsn);
					ai_rs.appendChild(document.createTextNode(' Análises'));


					if (cr.author.activity.posts > 0) {
						ai_psn.appendChild(document.createTextNode(cr.author.activity.posts));
						ai_ps.appendChild(ai_psn);
						ai_ps.appendChild(document.createTextNode(' Posts no fórum'));
					}

					aiactivity.appendChild(ai_gs);
					aiactivity.appendChild(ai_rs);
					aiactivity.appendChild(ai_ps);

					if (cr.author.rank == 'dev') {
						var ai_pbs = document.createElement('p'),
							ai_pbsn = document.createElement('b');
						ai_pbsn.appendChild(document.createTextNode(cr.author.activity.published));
						ai_pbs.appendChild(ai_pbsn);
						ai_pbs.appendChild(document.createTextNode(' Jogos Publicados'));
						aiactivity.appendChild(ai_pbs);
					}


					revfavbutton.setAttribute('class', 'fav-button ' + (cr.fav ? 'faved' : ''));
					revfavbutton.setAttribute('onclick', 'javascript:gpe.mReviews.favReview(' + cr.id + ')');
					ficon.setAttribute('class', 'fa fa-star');
					revfavbutton.appendChild(ficon);

					revauthorinfo.setAttribute('class', 'review-author-info');
					revauthorinfo.appendChild(ainamenphoto);
					revauthorinfo.appendChild(airank);
					revauthorinfo.appendChild(aiactivity);
					if(le.info.username.toString() == cr.author.sname.toString()) {
						var rmvRev = document.createElement('div'),
								rmvIcon = document.createElement('i');
						rmvIcon.setAttribute('class', 'fa fa-times');

						rmvRev.setAttribute('class', 'rmv-rev');
						rmvRev.setAttribute('onclick', 'javascript:gpe.mReviews.removeReview('+cr.id+');');
						rmvRev.setAttribute('data-js', 'hint');
						rmvRev.setAttribute('data-hint', 'Remover Review');
						rmvRev.setAttribute('data-hint-class', 'rmv-h');
						rmvRev.appendChild(rmvIcon);

						review.appendChild(rmvRev);
					}

					review.appendChild(therev);
					review.appendChild(revauthorinfo);
					review.appendChild(revfavbutton);
					review.setAttribute('class', 'a-review ' + (cr.info.type == 'up' ? 'positive' : 'negative'));
					review.setAttribute('id', 'mrvw_' + cr.id);
					$('.tmd>.reviews>.review-list').append(review);

					n++;
					gpe.mReviews.reviewCount++;
				}
				if(gpe.mReviews.reviewCount < gpe.mReviews.reviewsTotal){
					$('.reviews>.reviews-load-and-post').append('<div class="load-more" onclick="javascript:gpe.mReviews.loadMore(null, false);">Carregar mais análises</div>');
				}
				$('#loadingthisarea').fadeOut().remove();
			}
		},
		removeReview: function(rId){
			$('#mrvw_' + rId).fadeOut('slow', function(){
				$(this).remove();
			});
		},
		postNew: {
			uLiked: null,
			show: function(){

				$('.reviews>.post-new').slideDown(300, function() {
					$('html, body').animate({ scrollTop: $(".reviews>.post-new").offset().top }, 500);
				});

				$('.reviews>.post-new>.trvw-content').on('keyup', function () {
  				$('#review-count').text($('.reviews>.post-new>.trvw-content').text().length);
  //alert($('[name=game-desc]').val().length);
				});
				$('.reviews>.post-new>.u-liked>.hein>.opinion').on('click', function(){
					if($(this).hasClass('yep')) {
						gpe.mReviews.postNew.uLiked = true;
						$(this).removeClass('nono').addClass('focused');
						$('.reviews>.post-new>.u-liked>.hein>.opinion.nope').addClass('nono').removeClass('focused');
					}
					else if($(this).hasClass('nope')) {
						gpe.mReviews.postNew.uLiked = false;
						$(this).removeClass('nono').addClass('focused');
						$('.reviews>.post-new>.u-liked>.hein>.opinion.yep').addClass('nono').removeClass('focused');
					}
				});
			},
			post: function(){
				if(gpe.mReviews.postNew.uLiked === null) {
					$('.reviews>.post-new>.u-liked').fadeTo(100, 0.1).fadeTo(200, 1.0);
				}
				else if($('.reviews>.post-new>.trvw-content').text().length < 140){
					$('.reviews>.post-new>.warning').html('Uma análise deve ter ao menos 140 caracteres!');
					$('.reviews>.post-new>.warning').slideDown(300, function() {
						setTimeout(function() {
							$('.reviews>.post-new>.warning').slideUp(300, function() {
								$('.reviews>.post-new>.warning').html(' ');
							});
						}, 2000);
					});
				}
				else {
					console.log('Liked: ' + gpe.mReviews.postNew.uLiked);
					console.log('The review: ' + $('.reviews>.post-new>.trvw-content').text());
				}
			}

		}
	},
	mTabs: {
		curTab: "gallery",
		loadMedia: function () {
			var loading = '<div class="visible" id="loadingthisarea" style="margin:auto;margin-top:15%;width:150px;text-align:center;font-family:Strait,Droid Sans,MyriadPro,Arial,sans-serif;font-size:28px;display:none;">Carregando...</div>';
			$('.tmd').append(loading);
			$('#loadingthisarea').fadeIn('slow');
			gpe.mGallery.init();
		},

		watch: function () {
			$('[data-js*="mediatab"]').on("click", function () {
				var tab = $(this).attr('data-tab-name');
				if (gpe.mTabs.curTab != tab) {
					gpe.mTabs.changeTab(tab);
				}
			});
		},
		changeTab: function (tab) {
			$('.select-media>.current').removeClass("current");
			$('[data-tab-name*="' + tab + '"]').addClass("current");

			$('.tmd>.visible').removeClass("visible");
			$('.tmd>.' + tab).addClass("visible");

			gpe.mTabs.curTab = tab;
		}
	},
	mGallery: {
		init: function () {
			$.get("./get.php?gallery", function (data) {
				var d = data,
					gul = '.gallery>.media-list>.the-media-list>ul',
					n = 0;
				for (var i in d) {
					var item = document.createElement('li'),
						image = document.createElement('img'),
						icon = document.createElement('i');
					if (d[i].type == 'image') {
						image.setAttribute('src', d[i].url);
						icon.setAttribute('class', 'fa fa-picture-o m-icon');
					} else if (d[i].type == 'video/yt') {
						image.setAttribute('src', 'https://i1.ytimg.com/vi/' + ytId(d[i].url) + '/hqdefault.jpg');
						icon.setAttribute('class', 'fa fa-play-circle m-icon');
					} else {
						return false;
					}
					item.setAttribute('id', 'mi_' + n);
					item.setAttribute('data-media-type', d[i].type);
					item.setAttribute('data-media-url', d[i].url);
					item.setAttribute('onclick', 'javascript:gpe.mGallery.setSpotlightMedia($(this).attr("id"));');
					item.appendChild(image);
					item.appendChild(icon);
					$(gul).append(item);
					n++;
					//lulz[key].type
				}
				gpe.mTabs.changeTab('gallery');
				gpe.mGallery.setSpotlightMedia('mi_0');
			});
		},

		setSpotlightMedia: function (item) {
			var sw = $('.gallery>.spotlight-media'),
				i = $('#' + item);
			sw.hide();
			if (i.attr('data-media-type') == 'video/yt') {
				var te = document.createElement('iframe');
				te.setAttribute('width', '580');
				te.setAttribute('height', '326');
				te.setAttribute('frameborder', '0');
				te.setAttribute('allowfullscreen', '');
				te.setAttribute('src', '//www.youtube.com/embed/' + ytId(i.attr('data-media-url')) + '?autoplay=0&showinfo=0&controls=0');

				sw.html(te);
			} else if (i.attr('data-media-type') == 'image') {
				var te = document.createElement('img');
				te.setAttribute('src', i.attr('data-media-url'));
				sw.html(te);
			}
			sw.fadeIn();
			$('.gallery>.media-list>.the-media-list>ul>li.current').removeClass('current');
			i.addClass('current');
		}

	}
};
