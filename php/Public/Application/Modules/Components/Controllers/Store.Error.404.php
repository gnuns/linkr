<?php

class Error404Controller extends Control
{
	public function __construct($params = null)
	{
			$this->Tpl = new Template('404');
			//$this->Tpl->SetLabel('PageTitle', '/ Home');
			$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.User');
			$this->Tpl->SetLabel('PageTitle', NULL);
			//$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.User');
			$this->Tpl->WriteOutput();
		/*
		$eCode = $params[0];
		switch ($eCode) {
			case '404':
				$this->e404();
				break;

			default:
				header('Location: '.Core::readConfig('SITE/WWW').'/index.php');
				break;
		}*/
	}
}
