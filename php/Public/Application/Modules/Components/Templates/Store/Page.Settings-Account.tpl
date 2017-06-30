<!doctype html>
<html lang="pt-br">

<head>
	{:Head:}
</head>

<body>
	{TopBar}
	<div class="wrapper">
		<div class="body-container">
			<div class="default-container">

				<div class="usettings-sidebar">
					<div class="udata">
						<div class="avatar" style="background-image: url({UserAvatar})"></div>
						<div class="uname account">
							{UserName}
						</div>
						<div class="uname profile">
							{UserProfileName}
						</div>
					</div>

					<ul class="usettings-nav">
						<li>
							<a href="/settings">Perfil</a>
						</li>
						<li class="current">
							<a href="/settings/account">Conta</a>
						</li>
					</ul>
				</div>


				<div class="usettings-content">
					<div class="content-box">
						<div class="title">
							Alterar Senha
						</div>
						<form action="javascript:sttpe.postNewPwd();">
							<div class="r-form">

								<div class="form-item" id="curpwd">
									<div class="item-info">
										Senha atual:
									</div>
									<div class="item-input">
										<div class="input a-input">
											<input name="accpwd" type="password" tabindex="4" value="">
											<i class="a-icon fa fa-user"></i>
										</div>
									</div>
								</div>


								<div class="form-item" id="newpwd">
									<div class="item-info">
										Nova senha
									</div>
									<div class="item-input">
										<div class="input a-input">
											<input name="pwdnew" type="password" tabindex="4" value="">
											<i class="a-icon fa fa-user"></i>
										</div>
									</div>
								</div>

								<div class="form-item" id="newpwd2">
									<div class="item-info">
										Confirme a nova senha
									</div>
									<div class="item-input">
										<div class="input a-input">
											<input name="pwdnew2" type="password" tabindex="4" value="">
											<i class="a-icon fa fa-user"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="post-form big-go-button">
								<input type="submit" value="Alterar senha">
							</div>
						</form>
					</div>

					<div class="content-box">
						<div class="title">
							Alterar Email
						</div>
						<form action="javascript:sttpe.postNewMail();">
							<div class="r-form">

								<div class="form-item disabled">
									<div class="item-info">
										Email atual
									</div>
									<div class="item-input">
										<div class="input a-input">
											<input name="mailcur" type="text" tabindex="4" value="{UserMail}" disabled>
											<i class="a-icon fa fa-user"></i>
										</div>
									</div>
								</div>


								<div class="form-item" id="newmail">
									<div class="item-info">
										Novo Email
									</div>
									<div class="item-input">
										<div class="input a-input">
											<input name="mailnew" type="text" tabindex="4" value="" maxlength="64">
											<i class="a-icon fa fa-user"></i>
										</div>
									</div>
								</div>

								<div class="form-item" id="curpwdm">
									<div class="item-info">
										Digite sua senha
									</div>
									<div class="item-input">
										<div class="input a-input">
											<input name="accpwdm" type="password" tabindex="4" value="">
											<i class="a-icon fa fa-user"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="post-form big-go-button">
								<input type="submit" value="Alterar email">
							</div>
							</form>

					</div>
				</div>
			</div>
		</div>
		{:Footer:}
	</div>
	<script type="text/javascript" src="[static]/scripts/linkr.store.settings.js"></script>
	<script type="text/javascript">
    sttpe.initAccountSettings({IsPendingMail}, '{PendingMail}');
    </script>
</body>

</html>