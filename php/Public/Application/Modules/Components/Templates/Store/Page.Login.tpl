<!doctype html>
<html>

<head>
	{:Head:}
</head>

<body>
	{TopBar}
	<div class="wrapper">
		<div class="body-container">
			<div class="default-container">
				<div class="ral-page">
					<p class="title"><i class="fa fa-caret-right"></i> Login</p>
					<form action="#" onsubmit="le.postLogin(true); return false;">
						<div class="form-item" id="usr-i">
							<div class="item-input">
								<div class="input a-input">
									<input name="l-usr" type="text" value="" tabindex="4" placeholder="Nome de usuário">
									<i class="a-icon fa fa-user"></i>
								</div>
							</div>
						</div>
						<div class="form-item" id="usr-p">
							<div class="item-input">
								<div class="input a-input">
									<input name="l-pwd" type="password" value="" tabindex="4" placeholder="Senha">
									<i class="a-icon fa fa-lock"></i>
								</div>
							</div>
						</div>
						<div class="form-bottom">
							<a class="l-forg" href="/forgot-password">
                  Esqueceu sua senha?
              </a>
							<div class="go-button gogo">
								<input type="submit" value="Login">
							</div>
							<div class="go-button reg">
							<a href="/register">Ainda não tem uma conta?</a>
							</div>
						</div>
					</form>
				</div>
				<div class="ral-sidebar">
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
				</div>
			</div>

		</div>
		{:Footer:}
	</div>
</body>

</html>
