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
					<p class="title"><i class="fa fa-caret-right"></i> Criar uma conta</p>
					<form class="register-form" action="#" onsubmit="rpe.postRegister(); return false;">

						<div class="form-item" id="username">
							<div class="item-input">
								<div class="input a-input">
									<input type="text" name="username" value="" tabindex="4" placeholder="Nome de usuário">
									<i class="a-icon fa fa-user"></i>
								</div>
							</div>
							<div class="item-info">
								O nome que você usará na sua conta para fazer login, para url do seu perfil e para tudo mais.
							</div>
						</div>

						<div class="form-item" id="usermail">
							<div class="item-input">
								<div class="input a-input">
									<input name="email" type="text" value="" tabindex="4" placeholder="Endereço de email">
									<i class="a-icon fa fa-envelope"></i>
								</div>
							</div>
							<div class="item-info">
								Para recuperação de senha, confimação de compras e coisas do tipo.
							</div>
						</div>

						<div class="form-item" id="usermail2">
							<div class="item-input">
								<div class="input a-input">
									<input name="email-confirm" type="text" value="" tabindex="4" placeholder="Confirmação do email">
									<i class="a-icon fa fa-envelope"></i>
								</div>
							</div>
							<div class="item-info">
								(O seu email outra vez)
							</div>
						</div>

						<div class="form-item" id="pwd">
							<div class="item-input">
								<div class="input a-input">
									<input name="pwd" type="password" value="" tabindex="4" placeholder="Senha">
									<i class="a-icon fa fa-lock"></i>
								</div>
							</div>
							<div class="item-info">
								A sua senha de acesso.
							</div>
						</div>

						<div class="form-item" id="pwd2">
							<div class="item-input">
								<div class="input a-input">
									<input name="pwd-confirm" type="password" value="" tabindex="4" placeholder="Confirmação de senha">
									<i class="a-icon fa fa-lock"></i>
								</div>
							</div>
							<div class="item-info">
							</div>
						</div>

						<div class="form-item">
							<div class="center-item">
								<div class="lua_box">
									<div class="lua_body">
										{UserAgreement}
									</div>
								</div>
							</div>
						</div>
						<div class="form-item" id="captcha">
							<div class="item-input on-center">
								<div class="a-captcha">
									<div class="quest">
										<div class="refresh-button" onclick="javascript:rpe.reloadCaptcha();" data-js="hint" data-hint="Trocar desafio">
											<i class="fa fa-refresh"></i>
										</div>
									</div>
								</div>
								<div class="input a-input">
									<input name="captcha" type="text" value="" tabindex="4">
									<i class="a-icon fa fa-qrcode"></i>
								</div>
							</div>
						</div>
						<div class="form-bottom">
							<div class="did-u-really-read">
								<b> Atenção:</b> Ao completar o cadástro você estará concordando com os Termos de Uso e com a Política de Privacidade do Linkr. É muito importante que você tenha lido. (sério mesmo)
							</div>
							<div class="go-button gogo">
								<input value="Completar Cadástro" type="submit">
							</div>
						</div>
					</form>
				</div>
				<div class="ral-sidebar">

				</div>
			</div>

		</div>
		{:Footer:}
	</div>
	<script src="[static]/scripts/linkr.store.register.js"></script>
	<script>
		rpe.init();
	</script>
</body>

</html>
