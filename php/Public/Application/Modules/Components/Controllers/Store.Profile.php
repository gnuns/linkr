<?php
class ProfileController extends Control
{
	private $Tpl;
	private $userData;

	public function __construct($params = null)
	{
		if(isset($params[0])) 
		{
			$pUserId = UserData::getUserIDbyName(escape($params[0]));
			if($pUserId != false) {
				$this->Tpl = new Template('UserProfile');
				if(Session::isLoggedIn()) {
					$this->userData = Session::getCurrentUserData();
					$Tpl = $this->userTopHandler($this->userData);
				}
				else {
					$this->guestTopHandler();
				}

				$pUserData = new UserData($pUserId);

				$this->Tpl->SetLabel('PageTitle', '{p_UserProfileName} - ');
				$this->Tpl->SetLabel('p_UserProfileName', $pUserData->userProfileName);
				$this->Tpl->SetLabel('p_UserName', $pUserData->userName);
				$this->Tpl->SetLabel('p_UserMotto', $pUserData->userMotto);
				$this->Tpl->SetLabel('p_UserLocation', $pUserData->userLocation);
				$this->Tpl->SetLabel('p_UserAvatar', $pUserData->userAvatar);
				$this->Tpl->SetLabel('p_UserUrl', $pUserData->userUrl);
					
				$this->Tpl->WriteOutput();
				exit;
			}
		}
		header('Location: /');
		exit;
	}

	public function userTopHandler()
	{
		$this->userData = Session::getCurrentUserData();
		
		//$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.Guest');
		$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.User');
		//echo $_SESSION['LUID'];
		$this->Tpl->SetLabel('UserName', $this->userData->userName);
		$this->Tpl->SetLabel('UserProfileName', $this->userData->userProfileName);
		$this->Tpl->SetLabel('UserBalance',
												 number_format($this->userData->userBalance, 2, ',', '.'));
		$this->Tpl->SetLabel('UserAvatar', $this->userData->userAvatar);
	}
	public function guestTopHandler()
	{
		//Session::buildUserSession('Gnuns', '123456');
		//$this->Tpl->SetLabel('PageTitle', '/ Home');
		$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.Guest');

		//$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.User');
		//echo " Oi!" . genStats();  //. $_SESSION['LinkSSHASH'];

		//exit;
	}
}