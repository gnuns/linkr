<?php

Core::requireDataClass('User');

class Session
{
	private static $currentUserData;

	public static function Init()
	{
    session_save_path(Core::readConfig('SYSTEM/SESSIONDIR'));
    ini_set('session.gc_probability', 1); // For Debian

		if (!isset($_SESSION)) {
			session_cache_expire('3600');
			session_start();
		}
		/*session_unset();
    	session_destroy();
    	session_write_close();
    	setcookie(session_name(),'',0,'/');*/

		//session_destroy();
		//echo GenericModel::getUserIDbyName('Gnuns');
		//echo time().'<br>';
		// echo HashLib::getLinkPWDHASH('123456', 1, '1390527593');
		//$usrData = GenericModel::getUserData(1);
		//echo date("d/m/Y - H\hi", intval($usrData['m_lastlogin']));
	}

	public static function isLoggedIn()
	{
		// var_dump(isset($_COOKIE['LID']));
		// var_dump(isset($_SESSION['LUID']));
		// var_dump(isset($_SESSION['LSSHASH']));
		if(isset($_COOKIE['LID']) && isset($_SESSION['LUID']) &&
			 isset($_SESSION['LSSHASH']))
		{
			if($_COOKIE['LID'] == HashLib::getCookieID($_SESSION['LUID']))
			{
				$usrData = self::getCurrentUserData();
				$CurrentSSHASH = HashLib::getSSHASH($usrData->userName,
								 $usrData->userAuthHash, $usrData->userLastLogin);
				if($CurrentSSHASH == $_SESSION['LSSHASH'])
				{
					return true;
				}
			}
		}
		self::destroyUserSession();
		return false;
	}

	public static function getCurrentUserData()
	{
		if(isset($_SESSION['LUID']))
		{
			if(self::$currentUserData == null)
				self::$currentUserData = new UserData($_SESSION['LUID']);
			return self::$currentUserData;
		}
		return null;
	}

	public static function buildUserSession($uIdent, $uPWD)
	{
		Session::destroyUserSession();
		$uID = UserData::getUserIDbyName($uIdent);
		if(!$uID) {
			$uID = UserData::getUserIDbyMail($uIdent);
		}

		if(!$uID)
			return false;
		$usrData = new UserData($uID);
		if(HashLib::comparePwdHash($uID, $uPWD, $usrData->userAuthHash))
		{
			$usrData->setUserLastLogin();

			$SSHASH = HashLib::getSSHASH($usrData->userName, $usrData->userAuthHash,
																			 $usrData->userLastLogin);

			$_SESSION['LUID'] = $uID;
 			$_SESSION['LSSHASH'] = $SSHASH;

			// Cookie expira 30 dias depois da criação da sessão
			setcookie('LID', HashLib::getCookieID($uID), time()+60*60*24*30, '/', '.' . Core::readConfig('SITE/DOMAIN'));

			return TRUE;
		}
		return FALSE;
	}

	public static function buildSessionFromUserData($uData)
	{
		Session::destroyUserSession();
		$usrData = $uData;

		$usrData->setUserLastLogin();
		$SSHASH = HashLib::getSSHASH($usrData->userName, $usrData->userAuthHash, $usrData->userLastLogin);

		$_SESSION['LUID'] = $usrData->userId;
 		$_SESSION['LSSHASH'] = $SSHASH;
		// Cookie expira 30 dias depois da criação da sessão
		setcookie('LID', HashLib::getCookieID($usrData->userId), time()+60*60*24*30, '/', '.' . Core::readConfig('SITE/DOMAIN'));
	}

	public static function destroyUserSession()
	{
		//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();} // WHY???!??!?!?!

		unset($_SESSION['LUID']);
		unset($_SESSION['LSSHASH']);
		unset($_COOKIE['LID']);
		/* session_unset();
    	 session_destroy();
    	 session_write_close();
    	 setcookie(session_name(),'',0,'/'); */
	}
}
