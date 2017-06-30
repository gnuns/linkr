<?php
class EmailActivationController extends Control
{

	public function __construct($params = null)
	{
		if(isset($_GET['k'])) 
		{
			$aKey = escape(@$_GET['k']);
			$this->userData = UserData::activateEmail($aKey);
			if($this->userData == false) {
				header('Location: /');
			}
			else
			{
				Session::buildSessionFromUserData($this->userData);
				$this->userData = Session::getCurrentUserData();
				$this->Tpl = new Template('ActivateEmail');
				//$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.Guest');
				$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.User');
				$this->Tpl->SetLabel('PageTitle', 'Conta Ativada! - ');
		//echo $_SESSION['LUID'];
				$this->Tpl->SetLabel('UserName', $this->userData->userName);
				$this->Tpl->SetLabel('UserProfileName', $this->userData->userProfileName);
				$this->Tpl->SetLabel('UserBalance',
														 number_format($this->userData->userBalance, 2, ',', '.'));
				$this->Tpl->SetLabel('UserAvatar', $this->userData->userAvatar);
				$this->Tpl->WriteOutput();
			}
		}
		else {
			header('Location: /');
		}
		exit;
	}
}