	<noscript>
		<div class="top-bar-message">
			Desculpe, nosso site não funciona corretamente sem JavaScript!
			<br>
			<div class="sub">
				Por favor, <a href="http://www.enable-javascript.com/pt/" target="_blank">ative o Javascript</a> ou troque de browser para uma melhor experiência no Linkr.
			</div>
		</div>
	</noscript>
	<div class="c-bg community"></div>
	<div class="feedback-linkr" data-js="modal-trigger" data-modal-url="https://linkrgames.uservoice.com/clients/widgets/classic_widget?mode=full&link_color=20a066&forum_id=263525&primary_color=2a2d2c&trigger_background_color=20a066&embed_type=lightbox&trigger_method=pin&contact_enabled=true&feedback_enabled=true&smartvote=true&default_mode=feedback" data-modal-iframe="true" data-modal-name="Feedback">
		<img src="[static]/images/feedback-tab.png">
	</div>
	<div class="top-bar">
		<div class="default-container">
			<a class="logo-container community" href="http://comunidade.[domain]/">
				<div class="zkr"></div>
				<div class="name"></div>
			</a>

			<ul class="environ-nav">
				<li tabindex="1">
					<a href="http://loja.[domain]/" class="store"><i class="icon-shop"></i></a>
				</li>
				<li tabindex="2">
					<a href="http://comunidade.[domain]/" class="community current" data-js="hint" data-hint="Comunidade"> <i class="fa fa-users"></i></a>
				</li>
				<li tabindex="3">
					<a href="http://publique.[domain]/" class="publish" data-js="hint" data-hint="Publique"> <i class="fa fa-bullhorn"></i></a>
				</li>
			</ul>

			<form class="input search-input" action="[www]/search" method="get">
				<input id="thesearchinput" name="q" type="text" value="" tabindex="4">
				<i class="search-icon fa fa-search" onclick="javascript:$(this).parent().submit();"></i>
			</form>

			<ul class="part-nav">
				<li class="login" tabindex="5" data-js="dropdown" data-dropdown="#user-box"> <a class="login-button" href="[www]/login"> Login  </a>

					<!-- User box -->
					<div class="user-box login" id="user-box">
						<ul class="a-titles">
							<li class="login">Login</li>
							<li class="register" onclick="javascript:(function(){window.location='[www]/register';}());">Registre-se</li>
						</ul>
						<div class="the-login-box">
							<form onsubmit="javascript:le.postLogin(false);">
								<div class="input l-input">
									<input name="tb-usr" type="text" value="" tabindex="4" placeholder="Nome de usuário ou email">
									<i class="l-icon fa fa-user"></i>
								</div>
								<div class="input l-input">
									<input name="tb-pwd" type="password" value="" tabindex="4" placeholder="Sua senha">
									<i class="l-icon fa fa-lock"></i>
								</div>

								<div class="l-button" onclick="javascript:le.postLogin(false);">
									<input type="submit" value="Login">
								</div>
              </form>
               				<a href="[www]/resetpassword" class="l-forg">
	                  Esqueci minha senha!
	                </a>
						</div>
					</div>
					<!-- User box end -->
				</li>
			</ul>
		</div>
	</div>