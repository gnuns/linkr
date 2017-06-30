<?php
Core::requireDataClass('Games');
class HomeController extends Control
{
	private $Tpl;
	private $userData;

	public function __construct($params = null)
	{

		if(Session::isLoggedIn()) {
			//echo 'Aqui';
			$this->userHome();
			//Session::destroyUserSession();
		}
		else {
			//echo 'Aqui n ';
			//var_dump(Session::buildUserSession('ju@ba.com', '123456'));
			$this->guestHome();
		}
			//
			//exit;
		$this->Tpl->SetLabel('jDataSlider', '');
		$this->Tpl->SetLabel('jDataShowcase', '');
		$this->Tpl->WriteOutput();
		exit;
	}

	public function userHome()
	{
		$this->userData = Session::getCurrentUserData();
		$this->Tpl = new Template('Home');
		//$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.Guest');
		$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.User');
		$this->Tpl->SetLabel('PageTitle', NULL);
		$this->Tpl->SetLabel('jDataSlider', GamesData::getSlideshowGames());
		$this->Tpl->SetLabel('jDataShowcase', GamesData::getShowcaseGames());
		$this->Tpl->ParseLoop('FourUpdates', GamesData::getUpdatedGamesData());
		$this->Tpl->ParseLoop('HighLight-FirstFour', GamesData::getFeaturedGames());
//echo $_SESSION['LUID'];
		$this->Tpl->SetLabel('UserName', $this->userData->userName);
		$this->Tpl->SetLabel('UserProfileName', $this->userData->userProfileName);
		$this->Tpl->SetLabel('UserBalance',
												 number_format($this->userData->userBalance, 2, ',', '.'));
		$this->Tpl->SetLabel('UserAvatar', $this->userData->userAvatar);
	}
	public function guestHome()
	{
		//Session::buildUserSession('Gnuns', '123456');
		$this->Tpl = new Template('Home');
		//$this->Tpl->SetLabel('PageTitle', '/ Home');
		$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.Guest');
		$this->Tpl->SetLabel('PageTitle', NULL);
		$this->Tpl->SetLabel('jDataSlider', GamesData::getSlideshowGames());
		$this->Tpl->SetLabel('jDataShowcase', GamesData::getShowcaseGames());
		$this->Tpl->ParseLoop('FourUpdates', GamesData::getUpdatedGamesData());
		$this->Tpl->ParseLoop('HighLight-FirstFour', GamesData::getFeaturedGames());

		//$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.User');
		//echo " Oi!" . genStats();  //. $_SESSION['LinkSSHASH'];

		//exit;
	}
}
