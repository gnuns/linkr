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
						<li class="current">
							<a href="/settings">Perfil</a>
						</li>
						<li>
							<a href="/settings/account">Conta</a>
						</li>
					</ul>
				</div>

				<div class="usettings-content">
					<div class="content-box prof">
						<div class="title">
							Configurações do Perfil
						</div>
						<form action="javascript:sttpe.postProfileSettings();">
							<div class="r-form">

								<div class="form-item">
									<div class="item-info">
										Nome de exibição
									</div>
									<div class="item-input">
										<div class="input a-input">
											<input name="name" type="text" tabindex="4" value="{UserProfileName}"maxlength="20">
											<i class="a-icon fa fa-user"></i>
										</div>
									</div>
								</div>


								<div class="form-item">
									<div class="item-info">
										Frase de perfil
									</div>
									<div class="item-input">
										<div class="input a-input">
											<input name="motto" type="text" tabindex="4" value="{UserMotto}" maxlength="160">
											<i class="a-icon fa fa-user"></i>
										</div>
									</div>
								</div>

								<div class="form-item">
									<div class="item-info">
										Localização
									</div>
									<div class="item-input">
										<div class="input a-input">
											<input name="loc" type="text" tabindex="4" value="{UserLocation}" maxlength="75">
											<i class="a-icon fa fa-user"></i>
										</div>
									</div>
								</div>

								<div class="form-item">
									<div class="item-info">
										URL
									</div>
									<div class="item-input">
										<div class="input a-input">
											<input name="url" type="text" tabindex="4" value="{UserURL}" maxlength="75">
											<i class="a-icon fa fa-user"></i>
										</div>
									</div>
								</div>


							</div>
							<div class="profavatar">
								<div class="pa-img" style="background-image:url({UserAvatar})"></div>
								<div class="pa-buttons">
									<div class="chng">
										<div class="txt">Alterar</div>
										<input type="file" class="select" />
									</div>
									<div class="rmv" onclick="javascript:sttpe.removeAvatar();">
										Remover
									</div>
								</div>
							</div>
							<div class="post-form big-go-button">
								<input type="submit" value="Atualizar perfil">
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
    sttpe.init('{UserAvatarReal}', '{DefaultAvatar}');
    </script>
  </body>
</html>