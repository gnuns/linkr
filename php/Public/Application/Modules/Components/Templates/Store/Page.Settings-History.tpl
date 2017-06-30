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
						<li>
							<a href="/settings/account">Conta</a>
						</li>
						<li class="current">
							<a href="/settings/history">Histórico</a>
						</li>
					</ul>
				</div>

				<div class="usettings-content">

					<div class="content-box hist">
						<div class="title">
							Histórico de Logins
						</div>
						<ul class="us-list s-hl">
							<li class="ttl">
								<div class="item p1">
									Navegador
								</div>
								<div class="item p2">
									Endereço IP
								</div>
								<div class="item p3">
									Data/Hora
								</div>
							</li>
							<li>
								<div class="item p1">
									<i class="icon-firefox"></i> Mozilla Firefox no Linux
								</div>
								<div class="item p2">
									127.245.164.22
								</div>
								<div class="item p3">
									2014-02-28 23:12
								</div>
							</li>
							<li>
								<div class="item p1">
									<i class="icon-chrome"></i> Google Chrome no Windows
								</div>
								<div class="item p2">
									127.238.164.125
								</div>
								<div class="item p3">
									2014-02-28 21:01
								</div>
							</li>
							<li>
								<div class="item p1">
									<i class="icon-ie"></i> Internet Explorer no Windows 95
								</div>
								<div class="item p2">
									218.145.184.22
								</div>
								<div class="item p3">
									2014-01-14 19:01
								</div>
							</li>
							<li>
								<div class="item p1">
									<i class="icon-opera"></i> Opera no Nokia N97
								</div>
								<div class="item p2">
									218.248.164.22
								</div>
								<div class="item p3">
									2013-12-25 21:01
								</div>
							</li>
							<li>
								<div class="item p1">
									<i class="icon-firefox"></i> Mozilla Firefox no Windows
								</div>
								<div class="item p2">
									127.248.164.22
								</div>
								<div class="item p3">
									2010-02-28 21:01
								</div>
							</li>
							<li>
								<div class="item p1">
									<i class="icon-opera"></i> Opera no Nokia N97
								</div>
								<div class="item p2">
									218.248.164.22
								</div>
								<div class="item p3">
									2013-12-25 21:01
								</div>
							</li>
							<li>
								<div class="item p1">
									<i class="icon-chrome"></i> Google Chrome no Windows
								</div>
								<div class="item p2">
									127.238.164.125
								</div>
								<div class="item p3">
									2014-02-28 21:01
								</div>
							</li>
							<li>
								<div class="item p1">
									<i class="icon-firefox"></i> Mozilla Firefox no Linux
								</div>
								<div class="item p2">
									127.245.164.22
								</div>
								<div class="item p3">
									2014-02-28 23:12
								</div>
							</li>
							<li>
								<div class="item p1">
									<i class="icon-chrome"></i> Google Chrome no Windows
								</div>
								<div class="item p2">
									127.238.164.125
								</div>
								<div class="item p3">
									2014-02-28 21:01
								</div>
							</li>
						</ul>
						<div class="big-go-button post-form middle">
							Carregar anteriores
						</div>

					</div>
					<div class="content-box hist">
						<div class="title">
							Histórico Compras
						</div>
						<ul class="us-list s-hc">
							<li class="ttl">
								<div class="item p1">
									Itens
								</div>
								<div class="item p2">
									Preço
								</div>
								<div class="item p3">
									Meio de Pagamento
								</div>
								<div class="item p4">
									Data/Hora
								</div>
							</li>

							<!-- Itens! -->
							<li onclick="javascript:le.modalBox.show('Histórico - Detalhes da Compra', './get.php?wee');">
								<div class="item p1">
									Amnesia: Fear in Hands, Amnesia: The dark...
								</div>
								<div class="item p2">
									R$ 89,00
								</div>
								<div class="item p3">
									<i class="fa fa-credit-card"></i> Cartão de Crédito
								</div>
								<div class="item p4">
									2014-02-28 23:12
								</div>
							</li>

							<li>
								<div class="item p1">
									Amnesia: Fear in Hands, Amnesia: The dark...
								</div>
								<div class="item p2">
									R$ 89,00
								</div>
								<div class="item p3">
									<i class="fa fa-credit-card"></i> Cartão de Crédito
								</div>
								<div class="item p4">
									2014-02-28 23:12
								</div>
							</li>
							<li>
								<div class="item p1">
									Amnesia: Fear in Hands, Amnesia: The dark...
								</div>
								<div class="item p2">
									R$ 89,00
								</div>
								<div class="item p3">
									<i class="fa fa-barcode"></i> Boleto Bancário
								</div>
								<div class="item p4">
									2014-02-28 23:12
								</div>
							</li>
							<li>
								<div class="item p1">
									Amnesia: Fear in Hands, Amnesia: The dark...
								</div>
								<div class="item p2">
									R$ 89,00
								</div>
								<div class="item p3">
									<i class="fa fa-credit-card"></i> Cartão de Crédito
								</div>
								<div class="item p4">
									2014-02-28 23:12
								</div>
							</li>

						</ul>
						<div class="big-go-button post-form middle disabled">
							Carregar anteriores
						</div>

					</div>
				</div>
			</div>
		</div>
		{:Footer:}
	</div>
</body>

</html>