<?php

class UserData
{
	public $userId;
	public $userName;
	public $userMail;
	public $userProfileName;

	//public $userDevGroupIds;

	public $userAvatar;
	public $userIsDefaultAvatar;

	public $userLocation;
	public $userUrl;
	public $userMotto;

	public $userBalance = 0.00;

	public $userLastLogin;
	public $userLoginCount;
	public $userAccountCreation;

	public $userIspendingMail;
	public $userPendingMail;

	public $userAuthHash;

	/**
	 * Class to get all user account data
	 * @param int $uId User id
	 */
	public function __construct($uId)
	{
		//Data
		$uData = self::getUserDataArray($uId);

		if(!$uData)
			return FALSE;

		$this->userId = $uData['id'];

		$this->userName = descape($uData['username']);
		$this->userMail = descape($uData['email']);
		$this->userProfileName = descape($uData['profilename']);
		//$this->userDevGroupIds = intval($uData['m_devgroup_id']);
		$this->userAccountCreation = intval($uData['createdin']);
		$this->userLastLogin = intval($uData['lastlogin']);
		$this->userIsDefaultAvatar = empty($uData['avatarurl']);
		$this->userAvatar =  $this->userIsDefaultAvatar ? Core::readConfig('SITE/USERSTATIC') . '/avatar/no.jpg' : descape($uData['avatarurl']);
		$this->userBalance = $uData['balance'];
		$this->userAuthHash = $uData['authcode'];
		$this->userLocation = descape($uData['location']);
		$this->userUrl = descape($uData['userurl']);
		$this->userMotto = descape($uData['motto']);
		$this->userLoginCount = $uData['logincount'];
		$this->userIspendingMail = (($uData['ispendingmail'] == '1') ? TRUE: FALSE);
		$this->userPendingMail = (($this->userIspendingMail == TRUE) ? descape($uData['pendingmail']) : '');

		return TRUE;
	}

	/**
	 * Set last login timestamp to user
	 */
	public function setUserLastLogin()
	{
		Core::connectDB();
		global $Db;
		$Db->update('members_actions', array('last_login' => time()),
					'm_id = ' . intval($this->userId));
		$Db->updateSimple('members_actions', 'login_count = login_count + 1',
					'm_id = ' . intval($this->userId));
	}

	/**
	 * Update user password
	 * @param  string $pNewPwd SHA3 256 user password hash
	 * @return string          NEW HASH Password
	 */
	public function updateUserPassword($pNewPwd)
	{
		Core::connectDB();
		global $Db;
		$pwd = HashLib::genPwdHash($pNewPwd, intval($this->userId));
		$Db->update('members', array('m_secauthcode' => $pwd),
					"m_id = '" . intval($this->userId) . "'");
		//return $pwd;
	}

	/**
	 * Update user email
	 * @param  string $email New email address
	 * @return string        Activation key
	 */
	public function updateUserMail($email)
	{
		Core::connectDB();
		global $Db;
		$ak = HashLib::genActivationHash(intval($this->userId));
		$Db->update('members_actions', array(
			'activation_key' => $ak,
			'is_pending_mail' => '1',
			'pending_mail_address' => $email),
			"m_id = '" . intval($this->userId) . "'");
		return $ak;
	}

	/**
	 * Update user profile info
	 * @param  string $pName     Profile name
	 * @param  string $pAvatar   Avatar image url
	 * @param  string $pMotto    User profile motto
	 * @param  string $pLocation User profile location text
	 * @param  string $pUrl      User profile url
	 */
	public function updateUserProfileSettings($pName, $pAvatar, $pMotto, $pLocation, $pUrl)
	{
		Core::connectDB();
		global $Db;
		$Db->update('members_profile',
					array('m_profile_name' => $pName,
						  'm_avatar_url' => $pAvatar,
						  'm_motto' => $pMotto,
						  'm_location' => $pLocation,
						  'm_url' => $pUrl,
						),
					'm_id = ' . intval($this->userId));
	}

	/**
	 * Gets user info via MySQL
	 * @param  int	$uId 	User Id to get info
	 * @return array 		Array with user data
	 */
	private static function getUserDataArray($uId)
	{
		if($uId == FALSE)
			return FALSE;

		Core::connectDB();
		global $Db;

		$r = $Db->select('SELECT M.m_id AS id, M.m_name AS username, MP.m_profile_name AS profilename, M.m_mail AS email, M.m_secauthcode AS authcode,
M.m_acccreation_time AS createdin, MA.last_login AS lastlogin, M.m_balance AS balance,
MP.m_avatar_url AS avatarurl, MP.m_location AS location, MP.m_url AS userurl, MP.m_motto AS motto,
MA.is_pending_mail AS ispendingmail, MA.pending_mail_address AS pendingmail, MA.login_count AS logincount
FROM members AS M
LEFT JOIN members_profile AS MP ON M.m_id = MP.m_id
LEFT JOIN members_actions AS MA ON M.m_id = MA.m_id
WHERE M.m_id=:mid LIMIT 1',
					array(':mid' => intval($uId)));

		return isset($r[0]) ? $r[0] : FALSE;
	}

	/**
	 * Checks if name exists on database
	 * @param  string  $uName Username
	 * @return boolean        TRUE if exists, FALSE otherwise
	 */
	public static function isLinkrUsername($uName)
	{
		Core::connectDB();
		global $Db;

		$r = $Db->select('SELECT m_id AS id FROM members WHERE m_name=:mname LIMIT 1',
					array(':mname' => escape($uName)));

		return (isset($r[0]) && intval($r[0]['id']) > 0) ? TRUE : FALSE;
	}

	/**
	 * Checks if email exists on database
	 * @param  string  $uMail Email address
	 * @return boolean        TRUE if exists, FALSE otherwise
	 */
	public static function isLinkrMail($uMail)
	{
		Core::connectDB();
		global $Db;

		$r = $Db->select('SELECT m_id AS id FROM members WHERE m_mail=:mmail LIMIT 1',
					array(':mmail' => escape($uMail)));
		$v = (isset($r[0]) && intval($r[0]['id']) > 0) ? TRUE : FALSE;
		if(!$v) {
			$r = $Db->select('SELECT m_id AS id FROM members_actions WHERE pending_mail_address=:mmail LIMIT 1',
						array(':mmail' => escape($uMail)));
			return (isset($r[0]) && intval($r[0]['id']) > 0) ? TRUE : FALSE;
		}
		else {
			return TRUE;
		}
	}

	/**
	 * Get ID from username
	 * @param  string 		$uName Username
	 * @return int/boolean         Returns user id if exists, FALSE otherwise
	 */
	public static function getUserIDbyName($uName)
	{
		Core::connectDB();
		global $Db;

		$r = $Db->select('SELECT m_id FROM members WHERE m_name=:mname LIMIT 1',
					array(':mname' => escape($uName)));

		return isset($r[0]) ? intval($r[0]['m_id']) : FALSE;
	}
	/**
	 * Get ID from email
	 * @param  string 		$uMail Email address
	 * @return int/boolean         Returns user id if exists, FALSE otherwise
	 */
	public static function getUserIDbyMail($uMail)
	{
		Core::connectDB();
		global $Db;

		$r = $Db->select('SELECT m_id AS id FROM members WHERE m_mail=:mmail LIMIT 1',
					array(':mmail' => escape($uMail)));
		return (isset($r[0])) ? intval($r[0]['id']) : FALSE;
	}

	/**
	 * Registers a new linkr user account
	 * @param  string $username Username
	 * @param  string $email    User email
	 * @param  string $password SHA3 256 user password hash
	 * @return string        	Email activation key
	 */
	public static function registerNewUser($username, $email, $password)
	{
		Core::connectDB();
		global $Db;

		$Db->insert('members', array(
			'm_name' => $username,
			'm_mail' => $email,
			'm_secauthcode' => 'NOPE' . $password,
			'm_acccreation_time' => time(),
			'm_lastlogin' => '0'
		));

		$r = $Db->select('SELECT m_id AS id FROM members WHERE m_mail=:mmail LIMIT 1',
					array(':mmail' => escape($email)));
		$uid = intval($r[0]['id']);
		$Db->insert('members_profile', array(
			'm_id' => $uid,
			'm_profile_name' => $username)
		);
		$ak = HashLib::genActivationHash(intval($uid));
		$Db->insert('members_actions', array(
			'm_id' => $uid,
			'activation_key' => $ak,
			'is_pending_mail' => '1',
			'pending_mail_address' => $email
		));

		$Db->update('members', array('m_secauthcode' => HashLib::genPwdHash($password, $uid)),
								"m_id = '" . $uid . "'");

		return $ak;
	}

	public static function activateEmail($aKey)
	{
		Core::connectDB();
		global $Db;

		$r = $Db->select('SELECT m_id AS id FROM members_actions WHERE activation_key=:akey LIMIT 1',
					array(':akey' => escape($aKey)));
		$uId = (isset($r[0]) && intval($r[0]['id']) > 0) ? intval($r[0]['id']) : FALSE;

		if($uId === FALSE)
			return FALSE;
		else
		{
			$uData = new UserData($uId);

			$Db->update('members', array(
			'm_mail' => $uData->userPendingMail),
			"m_id = '" . intval($uId) . "'");

			$Db->update('members_actions', array(
			'activation_key' => '',
			'is_pending_mail' => '0',
			'pending_mail_address' => ''),
			"m_id = '" . intval($uId) . "'");

			// TODO: Add confirmation to log :D

			return $uData;
		}

	}

}
