/*global $, alert, linkr, le */
var rpe = {
	init: function() {
		rpe.reloadCaptcha();
	},
	reloadCaptcha: function() {
		$.get('/captcha/gen', function(res) {
			$('.a-captcha>.quest').css('background-image', 'url('+res.img+')');
		});
	},
	postRegister: function () {
		var sCaptcha = $('input[name=captcha]').val(),
				uName = $('input[name=username]').val(),
				uMail = $('input[name=email]').val(),
				uPass = le.crypto.hashPwd($('input[name=pwd]').val()),
				uMailConfirm = $('input[name=email-confirm]').val(),
				uPassConfirm = le.crypto.hashPwd($('input[name=pwd-confirm]').val());

		$(".form-item").removeClass("error");
		$(".form-item").removeClass("ok");


		$.post('/register/post', {
			'scaptcha': sCaptcha,
			'uname': uName,
			'umail': uMail,
			'upwd': uPass,
			'umail2': uMailConfirm,
			'upwd2': uPassConfirm
		}, function (res) {
			console.log(res);
			if(res == "ok") {
				window.location.href = "/";
			}

			if(res.scaptcha.toString() != 'ok') {
				$("#captcha").addClass("error");
			}
			rpe.reloadCaptcha();
			//If-Modified-Since: *
			// I actually have no idea if multiple switches are a good practice, but they are here :D
			switch(res.uname.toString()) {
					case '0': {
						$("#username").addClass("error");
						$("#username>.item-info").html('Nome de usuário inválido! <br> O seu username deve conter no mínimo 3 caracteres (letras de A-Z, números de 0-9, "_", "." e "-").');
						break;
					}
					case '1': {
						$("#username").addClass("error");
						$("#username>.item-info").html('Ops! Este nome de usuário já está em uso!');
						break;
					}
					case 'ok': {
						$("#username").addClass("ok");
						$("#username>.item-info").html('Ok!');
						break;
					}
			}

			switch(res.umail.toString()) {
					case '0': {
						$("#usermail").addClass("error");
						$("#usermail>.item-info").html("Email inválido!");
						break;
					}
					case '1': {
						$("#usermail").addClass("error");
						$("#usermail>.item-info").html('Endereço de email já registrado!<br> Você <a href="/resetpassword">esqueceu sua senha?</a>');
						break;
					}
					case 'ok': {
						$("#usermail").addClass("ok");
						$("#usermail>.item-info").html('Ok!');

						if(res.umail2 == '0') {
							$("#usermail2").addClass("error");
							$("#usermail2>.item-info").html('O email de confirmação não confere com o email inserido.');
						}
						else if(res.umail2 == 'ok') {
							$("#usermail2").addClass("ok");
							$("#usermail2>.item-info").html('Ok!');
						}
						break;
					}
			}

			switch(res.upwd.toString()) {
					case '0': {
						$("#pwd").addClass("error");
						$("#pwd>.item-info").html("Senha inválida! <br> Sua senha deve ter no mínimo 6 caracteres.");
						break;
					}
					case 'ok': {
						$("#pwd").addClass("ok");
						$("#pwd>.item-info").html("Ok!");

						if(res.upwd2 == '0') {
							$("#pwd2").addClass("error");
							$("#pwd2>.item-info").html("A confirmação de senha não confere com a senha inserida.");
						}
						else if(res.upwd2 == 'ok') {
							$("#pwd2").addClass("ok");
							$("#pwd2>.item-info").html("Ok!");
						}
						break;
					}
			}
		});
	}
};
