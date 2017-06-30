<?php
class SettingsController extends Control
{
	public function __construct($params = null)
	{

		if(!Session::isLoggedIn())
			header('Location: /');
		$this->userData = Session::getCurrentUserData();
		parent::loadParamMap(array( 'post' => true,
									'account' => true,
                              		'history' => true,
                              		'avatar' => false
                              		), $params);
		if (parent::getParam('avatar')) {
			print_r('
			<script>
			var options =   {
					            imageBox: \'.imageBox\',
					            thumbBox: \'.thumbBox\',
					            spinner: \'.spinner\',
					            imgSrc: \'avatar.png\'
					        };
			var cropper, isloaded = false;
			le.importScript("'.Core::readConfig('SITE/STATIC').'/scripts/" + "html5.min", function () {
				le.importScript("'.Core::readConfig('SITE/STATIC').'/scripts/" + "linkr.cropbox", function () {
					options.imgSrc = sttpe.avatarImgToCrop;
	                cropper = new cropbox(options);
				});
			});
			var updateAvatar = function() {
				if(isloaded) {
					sttpe.avatarImg = cropper.getDataURL();
					$(".pa-img").css("background-image", "url(\'"+sttpe.avatarImg+"\')");
				}
				le.modalBox.hide();
			}
			</script>				
    <div class="imageBox">
        <div class="thumbBox"></div>
        <div class="spinner" style="display: none">Loading...</div>
    </div>
    		<div class="cropControl">
    		<div class="post-form big-go-button" onclick="javascript:updateAvatar();">
							Atualizar avatar
						</div>
    		</div>

				');
			exit;
		}
		if(parent::getParam('post') == 'profile' && isset($_POST['pname']))
		{
			
			$pName = substr(escape(@$_POST['pname']), 0, 20);
			$pMotto = substr(escape(@$_POST['pmotto']), 0, 160);
			$pLoca = substr(escape(@$_POST['ploc']), 0, 75);
			$pUrl = substr(escape(@$_POST['purl']), 0, 75);

			$pAvatarData = @explode(";", $_POST['pavatar']); // 0: data:image/format; 1: base64,code
			$pAvatar = @base64_decode(explode(",", $pAvatarData[1])[1]);

			//print("$pName \n $pMotto \n $pLoca \n $pUrl \n $pAvatar \n");

			if(((startsWith($pUrl, 'http://') || startsWith($pUrl, 'https://')) &&
				filter_var($pUrl, FILTER_VALIDATE_URL)) ||
				strlen(str_replace(' ', '', $pUrl)) == 0){	}
			else 
			{
				$pUrl = '';
				//exit;
			}

			if (@$_POST['pavatar'] == 'default')
			{
				$pAvatarName = '';
			}
			else if(empty($pAvatar))
			{
				//print("IMAGEM EM BRANCO!");
				$pAvatarName = $this->userData->userAvatar;
			}
			else if(@imagecreatefromstring($pAvatar) !== false)
			{
				//http://us3.php.net/imagecreatefromstring
				//print("IMAGEM VÁLIDA " . $pAvatarData[0]);
				switch (strtolower($pAvatarData[0])) {
					case 'data:image/png':
						$pAvatarName = $this->userData->userId . '.' .
									   time() . '_' . sha1($pAvatar) . '.png';
						file_put_contents(LD_USTATIC . DS . 'avatar' . DS . $pAvatarName, $pAvatar);
						$pAvatarName = (Core::readConfig('SITE/USERSTATIC') . '/avatar/' . $pAvatarName);
						break;
					/*
					case 'data:image/jpg':
					case 'data:image/jpeg':
						print('JPEG!');
						break;
					case 'data:image/gif':
						print('GIF!');
						break;
					*/
				}
			}
			else {
				$pAvatarName = $this->userData->userAvatar;
				//print("IMAGEM INVÁLIDA");
			}
			$this->userData->updateUserProfileSettings($pName, $pAvatarName,
				$pMotto, $pLoca, $pUrl);
/*$im = imagecreatefromstring($data);
if ($im !== false) {
    header('Content-Type: image/png');
    imagepng($im);
    imagedestroy($im);
}*/
			//filter_var($url, FILTER_VALIDATE_URL);
			exit;

		}
		else if(parent::getParam('post') == 'account')
		{
			if(isset($_POST['unewpwd'])) 
			{
				$uPwd = escape(@$_POST['upwd']);
				$uNewPwd = escape(@$_POST['unewpwd']);
				$uNewPwdConfirm = escape(@$_POST['unewpwd2']);

				$r = array('result' => '0');
				if(!HashLib::comparePwdHash($this->userData->userId, $uPwd, $this->userData->userAuthHash))
				{
					$r['result'] = '1';
				}
				else if(empty($uNewPwd) || $uNewPwd == '' || strlen($uNewPwd) != 64) {
					$r['result'] = '2';
				}
				else if($uNewPwd != $uNewPwdConfirm) {
					$r['result'] = '3';
				}
				// If user chooses the current password as the new password, just return 'ok'
				else if(HashLib::comparePwdHash($this->userData->userId, $uNewPwd, $this->userData->userAuthHash))
				{
					$r['result'] = 'ok';
				}
				else {
					$this->userData->updateUserPassword($uNewPwd);
					if(Session::buildUserSession($this->userData->userName, $uNewPwd)) {
						$r['result'] = 'ok';
					}
				}
				header('Content-type: application/json');
				//var_dump(Session::isLoggedIn());
				print(json_encode($r));
				
			}
			else if(isset($_POST['unewmail'])) {
				$uPwd = escape(@$_POST['upwd']);
				$uNewMail = escape(@$_POST['unewmail']);

				$r = array('result' => '0');
				if(!HashLib::comparePwdHash($this->userData->userId, $uPwd, $this->userData->userAuthHash))
				{
					$r['result'] = '1';
				}
				else if(!filter_var($uNewMail, FILTER_VALIDATE_EMAIL) || UserData::isLinkrMail($uNewMail)) {
					$r['result'] = '2';
				}
				else if($this->userData->userMail == $uNewMail) {
					$r['result'] = '0';
				}
				else {
					$activationKey = $this->userData->updateUserMail($uNewMail);
					MailLib::sendMail('ConfirmEmailChange', 'Confirme o seu novo email no Linkr, '.$this->userData->userName.'!',
							$uNewMail, $this->userData->userName,
							array(
								'Today' => date("d/m/Y"),
								'UserName' => $this->userData->userName,
								'ConfirmLink' => 'http://'.Core::readConfig('SITE/DOMAIN').'/confirm?k='. $activationKey//$this->userData->setPendingMail()
							), 'email-change');
					$r['result'] = 'ok';
					
				}
				header('Content-type: application/json');
				//var_dump(Session::isLoggedIn());
				print(json_encode($r));
			}
			exit;
		}
		else if(parent::getParam('post') == 'history')
		{
			//print_r($_POST);
			exit;
		}


		if(parent::getParam('account')) 
		{
			$Sub = '-Account';
		}
		else if(parent::getParam('history')) 
		{
			$Sub = ''; //'-History';
		}
		else
		{
			$Sub = '';
		}

		$this->Tpl = new Template('Settings' . $Sub);
		//$this->Tpl->SetLabel('PageTitle', '/ Home');
		$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.User');
		$this->Tpl->SetLabel('PageTitle', 'Configurações -');
			//$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.User');
		$this->Tpl->SetLabel('UserName', $this->userData->userName);
		$this->Tpl->SetLabel('UserProfileName', $this->userData->userProfileName);
		$this->Tpl->SetLabel('UserBalance', number_format($this->userData->userBalance, 2, ',', '.'));
		$this->Tpl->SetLabel('UserAvatar', $this->userData->userAvatar);
		$this->Tpl->SetLabel('UserAvatarReal', $this->userData->userIsDefaultAvatar ? '' :  $this->userData->userAvatar);
		$this->Tpl->SetLabel('UserMotto', $this->userData->userMotto);
		$this->Tpl->SetLabel('UserLocation', $this->userData->userLocation);
		$this->Tpl->SetLabel('UserURL', $this->userData->userUrl);
		$this->Tpl->SetLabel('UserMail', $this->userData->userMail);
		$this->Tpl->SetLabel('IsPendingMail', $this->userData->userIspendingMail ? 'true' : 'false');
		$this->Tpl->SetLabel('PendingMail', $this->userData->userPendingMail);
		$this->Tpl->SetLabel('DefaultAvatar', Core::readConfig('SITE/USERSTATIC') . '/avatar/no.jpg');
		$this->Tpl->WriteOutput();
		
	}
}
