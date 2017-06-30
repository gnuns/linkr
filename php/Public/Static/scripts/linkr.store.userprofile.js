var upe = null;

function timeConverter(uts) {
	var t = new Date(uts * 1000);
	return (t.toLocaleTimeString() + ' ' + t.toLocaleDateString());
}

le.userProfile = {
	init: function () {
		upe = le.userProfile;
		//this.mComments.init();
	},

	mComments: {
		commentCount: 0,
		commentsTotal: 0,
		init: function () {
			upe.mComments.loadMore(iniReviewData, true);
		},
		loadMore: function (data, isJsonInput) {

			$('.comments>.comments-load-and-post>.load-more').remove();
			if (!isJsonInput) {
				var loading = '<div class="visible" id="loadingthisarea" style="margin:auto;margin-top:15px;margin-bottom:30px;width:150px;text-align:center;font-family:Strait,Droid Sans,MyriadPro,Arial,sans-serif;font-size:28px;display:none;">Carregando...</div>';
				$('.comments>.comment-list').append(loading);

				$('#loadingthisarea').fadeIn('slow');

				$.get("./get.php?reviews&curcount=" + upe.mComments.reviewCount + "&game=thisgmae", function (data) {
					upe.mComments.loadMore(data, true);
				});
			} else {
				var d = data['reviews'],
					rl = '.comments>.comment-list',
					n = 0;
				upe.mComments.commentsTotal = data['reviews.total'];
				for (var rvw in d) {
					var cr = d[rvw],
						content = '<div class="a-comment" id="comm_' + cr.id + '">' +
						(le.info.username.toString() == cr.author.sname.toString() ? '<div data-hint-class="rmv-h" data-hint="Remover Comentário" data-js="hint" onclick="javascript:upe.mComments.removeComment(' + cr.id + ');" class="rmv-comment"><i class="fa fa-times"></i></div>' : '') +
						'<div class="author-img" onclick="javascript:le.goToProfile(\'' + cr.author.sname + '\');" style="background-image: url('+cr.author.avatar+')">' +
						'<div class="author-rank-strip ' + cr.author.rank + '">' +
						(cr.author.rank == 'dev' ? 'Dev' : (cr.author.rank == 'gamer' ? 'Gamer' : 'Membro')) +
						'</div></div>' +
						'<div class="the-comment">' +
						'<div class="comment-title">' +
						'	<span class="author-name" onclick="javascript:le.goToProfile(\'' + cr.author.sname + '\');">' + cr.author.name + ' </span>' +
						'	<span class="comment-timestamp"> há 15 minutos</span>' +
						'</div>' +
						'<div class="comment-content">' +
						cr.content +
						'</div></div></div>';
					upe.mComments.commentCount++;
					$(rl).append(content);

				}
				if (upe.mComments.commentCount < upe.mComments.commentsTotal) {
					$('.comments>.comments-load-and-post').append('<div class="load-more" onclick="javascript:upe.mComments.loadMore(null, false);">Carregar mais comentários</div>');
				}
				$('#loadingthisarea').fadeOut().remove();
			}
		},
		removeComment: function (rId) {
			$('#comm_' + rId).fadeOut('slow', function () {
				$(this).remove();
			});
		},
		postNew: {
			show: function () {
				if(!le.info.logged) {
					window.location.href = '/login';
				}
				else {
					$('.comments>.post-new').slideDown(300, function () {
						$('html, body').animate({
							scrollTop: $(".comments>.post-new").offset().top
						}, 500);
					});
				}
			},
			post: function () {
				if(!le.info.logged) {
					window.location.href = '/login';
				}
				else {
					if ($('.comments>.post-new>.tcmm-content').text().length <= 1) {
						$('.comments>.post-new>.warning').html('Seu comentário não pode ficar em branco! <i class="fa fa-meh-o"></i>');
						$('.comments>.post-new>.warning').slideDown(300, function () {
							setTimeout(function () {
								$('.comments>.post-new>.warning').slideUp(300, function () {
									$('.comments>.post-new>.warning').html(' ');
								});
							}, 2000);
						});
					} else {
						console.log('Liked: ' + upe.mComments.postNew.uLiked);
						console.log('The review: ' + $('.comments>.post-new>.tcmm-content').text());
					}
				}
			}

		}
	}
}
