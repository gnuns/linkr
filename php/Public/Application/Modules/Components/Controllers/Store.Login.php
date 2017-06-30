<?php

class LoginController extends Control
{

	public function __construct($params = null)
	{
		parent::loadParamMap(array( 'post' => true), $params);
		if (parent::getParam('post') && Session::isLoggedIn() && isset($_POST['uidentity'])) 
		{
			$result = array(
				'result' => '1'
			);
			header('Content-type: application/json');
			//var_dump(Session::isLoggedIn());
			print(json_encode($result));
		}
		else if(Session::isLoggedIn())
		{
			header('Location: ' . '/');
		}
		else if (parent::getParam('post') && isset($_POST['uidentity'])) 
		{
			/////////////////////////////////////////////////////////////////////////
			// THIS IS A SHITTY WAY TO AVOID BRUTEFORCE, PLEASE REWRITE DIS SHIT.
			/////////////////////////////////////////////////////////////////////////
			$_SESSION['LLOGIN_POST_COUNT'] = intval(@$_SESSION['LLOGIN_POST_COUNT']) + 1;
			if(!isset($_SESSION['LLOGIN_POST_LAST'])) {
				$_SESSION['LLOGIN_POST_LAST'] = time();
			}
			else if(intval($_SESSION['LLOGIN_POST_LAST']) > intval(time() - 20) // Menos de 20 segundos atrás
							&& $_SESSION['LLOGIN_POST_COUNT'] >= 25) // 25 ou mais tentativas de post
			{
				$result = array(
					'result' => '0'
				);
				header('Content-type: application/json');
				//var_dump(Session::isLoggedIn());
				print(json_encode($result));
				exit;
			}
			else if(intval($_SESSION['LLOGIN_POST_LAST']) <= intval(time() - 600)) {
				$_SESSION['LLOGIN_POST_COUNT'] = 1;
			}
			$_SESSION['LLOGIN_POST_LAST'] = time();
			////////////////////////////////////////////////////////////////////////



			// Yeah, with error suppressors
			$uIdentity = escape(@$_POST['uidentity']);
			$uPwd 	= escape(@$_POST['upwd']);
			
			// 0, 1 or ok
			// Should i give less info? (like only 1 or 0)
			$result = array(
				'result' => '0'
			);
			if(Session::buildUserSession($uIdentity, $uPwd)){
				$result['result'] = 'ok';
			}
			else {
				$result['result'] = '0';
			}
			# LAST CHECK AND REGISTER!
			/*if($result['uname'] == 'ok' && $result['umail'] == 'ok' && $result['umail2'] == 'ok' &&
				$result['upwd'] == 'ok' && $result['upwd2'] == 'ok') 
			{
				UserData::registerNewUser($uName, $uMail, $uPwd);
				if(Session::buildUserSession($uName, $uPwd)){
					header('Content-type: text/plain');
					print('ok');
					exit;
				}
			}*/
			header('Content-type: application/json');
			//var_dump(Session::isLoggedIn());
			print(json_encode($result));
		}
		else
		{
				$this->Tpl = new Template('Login');
				//$this->Tpl->SetLabel('PageTitle', '/ Home');
				$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.Guest');
				$this->Tpl->SetLabel('PageTitle', 'Criar uma conta -');
				//$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.User');
				$this->Tpl->WriteOutput();
		}
		exit;
		/*
							if(Session::isLoggedIn()){
				header('Content-type: text/plain');
				echo 'logged';
			}
		*/
	}
}

