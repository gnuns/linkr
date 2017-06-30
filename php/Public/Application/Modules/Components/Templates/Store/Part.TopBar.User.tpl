    <noscript>
      <div class="top-bar-message">
        Desculpe, nosso site não funciona corretamente sem JavaScript!
        <br>
        <div class="sub">
          Por favor, <a href="http://www.enable-javascript.com/pt/" target="_blank">ative o Javascript</a> ou troque de browser para uma melhor experiência no Linkr.
        </div>
      </div>
    </noscript>
    <div class="c-bg"></div>
    <div class="feedback-linkr" data-js="modal-trigger" data-modal-url="https://linkrgames.uservoice.com/clients/widgets/classic_widget?mode=full&link_color=20a066&forum_id=263525&primary_color=2a2d2c&trigger_background_color=20a066&embed_type=lightbox&trigger_method=pin&contact_enabled=true&feedback_enabled=true&smartvote=true&default_mode=feedback" data-modal-iframe="true" data-modal-name="Feedback"> <img src="[static]/images/feedback-tab.png"> </div>
    <div class="top-bar">
		<div class="default-container">
			<a class="logo-container store" href="[www]/">
				<div class="zkr"></div>
				<div class="name"></div>
			</a>

			<ul class="environ-nav">
				<li tabindex="1">
					<a href="http://loja.[domain]/" class="store current"><i class="icon-shop"></i></a>
				</li>
				<li tabindex="2">
					<a href="http://comunidade.[domain]/" class="community" data-js="hint" data-hint="Comunidade"> <i class="fa fa-users"></i></a>
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
				<li tabindex="4" data-js="dropdown" data-dropdown="#genres-box"> <i class="fa fa-gamepad" data-js="hint" data-hint="Games">
          </i>
					<!-- Games box -->
					<div class="games-box" id="genres-box">
						<ul class="sub-menu">
							<li>Ação</li>
							<li>Aventura</li>
							<li>Card Game</li>
							<li>Casual</li>
							<li>Estratégia</li>
							<li>FPS</li>
							<li>Gerenciamento</li>
							<li>Plataforma</li>
							<li>Puzzle</li>
							<li>Retrô</li>
							<li>RPG</li>
							<li>Terror</li>
						</ul>
					</div>
					<!-- Games box end -->
				</li>
				<li tabindex="5" data-js="dropdown" data-dropdown="#s-cart-box">
					<div class="shopping-cart"> <i class="fa fa-shopping-cart" data-js="hint" data-hint="Carrinho de Compras"></i>
						<div class="shopping-cart-items">3</div>
					</div>
					<!-- shopping-cart-box -->
					<div class="shopping-cart-box" id="s-cart-box">
						<ul class="game-list"></ul>
						<div class="total-price" data-js="hint" data-hint="Completar compra" data-hint-class="buy-h">
							<div class="wtf">
								Preço Total:
							</div>
							<div class="price">
								R$ 0,00
							</div>
							<div class="buy">
								<i class="fa fa-chevron-circle-right"></i>
							</div>
						</div>
					</div>
					<!-- shopping-cart-box end -->

				</li>

				<li tabindex="6" data-js="dropdown" data-dropdown="#user-box"> <i class="fa fa-cog" data-js="hint" data-hint="Detalhes da conta"></i>

					<!-- User box -->
					<div class="user-box logged" id="user-box">
						<div class="profile-photo">
							<img src="{UserAvatar}">
						</div>
              <div class="profile-username">
                {UserName}
              </div>
              <div class="profile-fullname">
                {UserProfileName}
              </div>
						<div class="buttons">
							<div class="goto" data-js="hint goto" data-goto="[www]/u/{UserName}" data-hint="Perfil">
								<i class="fa fa-user"></i>
							</div>
							<!-- <div class="goto" data-js="hint goto" data-goto="[www]/library" data-hint="Coleção">
								<i class="fa fa-archive"></i>
							</div> -->
							<div class="goto" data-js="hint goto" data-goto="[www]/settings" data-hint="Configurações">
								<i class="fa fa-cogs"></i>
							</div>
							<!-- <div class="goto" data-js="hint" data-hint="Saldo" >
								R$ {UserBalance}
							</div> -->
							<div class="exit" data-js="goto"  data-goto="[www]/logout">
								Sair
							</div>
						</div>
					</div>
					<!-- User box end -->

				</li>
			</ul>
		</div>
	</div>
