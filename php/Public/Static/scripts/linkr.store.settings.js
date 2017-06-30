/*global $, alert, linkr, le */
function utf8_to_b64( str ) {
  return window.btoa(unescape(encodeURIComponent( str )));
}
function b64_to_utf8( str ) {
  return decodeURIComponent(escape(window.atob( str )));
}
var sttpe = {
	avatarImg: '',
	defaultAvatar: '',
	avatarImgToCrop: '',
	init: function(aImg, daImg) {
		sttpe.avatarImg = aImg;
   	sttpe.defaultAvatar = daImg;
		$('.chng>.select').change(function(){

			if ( this.files && this.files[0] ) {

				if(this.files[0].type.indexOf("image") > -1) 
				{
					if((this.files[0].size / 1024) <= 1024) // 1MB 
					{
		        var FR= new FileReader();
		        
		        console.log(this.files[0]);
		        //$('.pa-img').css('background-image', "url('"+this.files[0].src+"')");
		        FR.onload = function(e) {
		             //$('#img').attr( "src", e.target.result );
		             //$('.pa-img').css('background-image', "url('"+e.target.result+"')");
		             sttpe.avatarImgToCrop = e.target.result.toString();
		             le.modalBox.show('Cortar avatar', '/settings/avatar');
		             //$('#base').text( e.target.result );
		        };       
		        FR.readAsDataURL( this.files[0] );
	        }
	        else {
	        	alert("Arquivo muito grande! Por favor escolha uma imagem com até 1MB");
	        }
	      }
	      else {
	      	alert("Tipo de arquivo inválido!");
	      	return;
	      }
	    }
		});
	},
	initAccountSettings: function(ipn, nml){
		if(ipn) {
			$('#newmail').addClass('warning');
			$('#newmail>.item-info').html('Novo Email <span class="info">(Confirmação pendente)</span>');
			$('input[name=mailnew]').val(nml);
		}
	},
	postProfileSettings: function(){
		var profName = $('input[name=name]').val(),
				profMotto = $('input[name=motto]').val(),
				profLocation = $('input[name=loc]').val(),
				profUrl = $('input[name=url]').val(),
				profAvatar = sttpe.avatarImg;
		$.post('/settings/post/profile', {
			'pname': profName,
			'pmotto': profMotto,
			'ploc': profLocation,
			'purl': profUrl,
			'pavatar': profAvatar
		}, function(req){
			//console.log(req);
			/*$.gritter.add({
				title: "Perfil Atualizado",
				text:  "Suas informações de perfil foram atualizadas com sucesso!",
				after_close: function(){
					window.location.href = '/settings';
				}
			});*/
			window.location.href = '/settings';
		});
	},
	postNewMail: function(){
		var curPwd = le.crypto.hashPwd($('input[name=accpwdm]').val()),
				newMail = $('input[name=mailnew]').val();
		$.post('/settings/post/account', {
			'upwd' : curPwd,
			'unewmail': newMail
		}, function(resp) {
			$('.form-item').removeClass('error');
			$('.form-item').removeClass('ok');
			console.log(resp);
			switch(resp.result.toString()) {
				case '0': {
					window.location.href = '/settings/account';
					break;
				}
				case '1': {
					$('#curpwdm').addClass('error');
					$.gritter.add({
						title: "Senha incorreta",
						text:  "A senha informada não corresponde à senha atual da conta",
						image: le.statics + 'images/fail-32.png'
					});
					break;
				}
				case '2': {
					$('#newmail').addClass('error');
					$('#curpwdm').addClass('ok');
					$.gritter.add({
						title: "Novo Email Inválido",
						text:  "O novo email precisa ser válido e não pode estar vinculado à nenhuma outra conta do Linkr!",
						image: le.statics + 'images/fail-32.png'
					});
					break;
				}
				case 'ok': {
					$('input[name=accpwdm]').val('');
					$('input[name=accpwdm]').val('');
					$('input[name=mailnew]').val('');
					$.gritter.add({
						title: "Pronto!",
						text:  "O seu email foi alterado com sucesso! Acesse o link de confirmação para completar a alteração!",
						image: le.statics + 'images/ok-32.png',
						after_close: function(){
							window.location.href = '/settings/account';
						}
					});
					break;
				}

			}
			return;
			/*switch(resp.toString()) {

			}*/
		});
	},
	postNewPwd: function(){
		var curPwd = le.crypto.hashPwd($('input[name=accpwd]').val()),
				newPwd = le.crypto.hashPwd($('input[name=pwdnew]').val()),
				newPwdConfirm = le.crypto.hashPwd($('input[name=pwdnew2]').val());
		console.log('1 ' + newPwd);
		console.log('2 ' + newPwdConfirm);
		$.post('/settings/post/account', {
			'upwd' : curPwd,
			'unewpwd': newPwd,
			'unewpwd2': newPwdConfirm
		}, function(resp) {
			$('.form-item').removeClass('error');
			$('.form-item').removeClass('ok');
			switch(resp.result.toString()) {
				case '0':
				case '1': {
					$('#curpwd').addClass('error');
					$.gritter.add({
						title: "Senha incorreta",
						text:  "A senha informada não corresponde à senha atual da conta",
						image: le.statics + 'images/fail-32.png'
					});
					break;
				}
				case '2': {
					$('#newpwd').addClass('error');
					$('#curpwd').addClass('ok');
					$.gritter.add({
						title: "Nova senha inválida!",
						text:  "A sua senha deve possuir no mínimo 6 caracteres.",
						image: le.statics + 'images/fail-32.png'
					});
					break;
				}
				case '3': {
					$('#newpwd2').addClass('error');
					$('#newpwd').addClass('ok');
					$('#curpwd').addClass('ok');
					$.gritter.add({
						title: "Confirmação Inválida!",
						text:  "A confirmação não corresponde à senha informada",
						image: le.statics + 'images/fail-32.png'
					});
					break;
				}
				case 'ok': {
					$('input[name=accpwd]').val('');
					$('input[name=pwdnew]').val('');
					$('input[name=pwdnew2]').val('');
					$.gritter.add({
						title: "Pronto!",
						text:  "Sua senha foi alterada com sucesso!",
						image: le.statics + 'images/ok-32.png'
					});
					break;
				}

			}
			return;
			/*switch(resp.toString()) {

			}*/
		});
	},
	removeAvatar: function(){
		if(sttpe.avatarImg == 'default' || sttpe.avatarImg == '') {
			alert('Opss... Você já está com o avatar padrão!');
		}
		else {
			$('.pa-img').css('background-image', "url('"+sttpe.defaultAvatar+"')");
			sttpe.avatarImg = 'default';
		}
	}

};