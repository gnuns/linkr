<?php
class InfoController extends Control
{

	public function __construct($params = null)
	{
		if(isset($_POST['ua'])) 
		{
			$info['logged']	= Session::isLoggedIn();
			if(Session::isLoggedIn()) {
				$uData = Session::getCurrentUserData();
				$info['username'] = $uData->userName;
			}
			else
			{
				$info['username'] = '';
			}
			header('Content-type: application/json');
			//var_dump(Session::isLoggedIn());
			print(json_encode($info));
		}
		else { 
			header('Location: /');
		}
		exit;
	}
}