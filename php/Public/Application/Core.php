<?php

// Debug mode: TRUE or FALSE
define('L_DEBUG', TRUE);

// System charset
define('L_CHARSET', 'utf-8');
define('USERIP', $_SERVER['REMOTE_ADDR']);

// Error reporting TRUE if L_DEBUG is true
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Directory Defs
define('DS', DIRECTORY_SEPARATOR);

define('LD_USTATIC', dirname(__FILE__) . DS . '..' . DS. 'UserStatic'); // Linkr Directory: UserStatic
define('LD_APP', dirname(__FILE__) . DS); // Linkr Directory: Application
define('LD_SESS', LD_APP . '.LinkrSession' . DS);
define('LD_MODS_3RD', LD_APP . 'Modules' . DS . 'ThridParty' . DS);
define('LD_MODS_COMP', LD_APP . 'Modules' . DS . 'Components' . DS);

// Required Files
require_once(LD_APP . 'Configuration.php');

require_once(LD_APP . 'Environment' . DS . 'Function.php');
require_once(LD_APP . 'Environment' . DS . 'Router.php');

require_once(LD_APP . 'Modules' . DS . 'Hash.php');
require_once(LD_APP . 'Modules' . DS . 'Database.php');;
require_once(LD_APP . 'Modules' . DS . 'Session.php');

require_once(LD_APP . 'Modules' . DS . 'Control.php');
require_once(LD_APP . 'Modules' . DS . 'Template.php');
require_once(LD_APP . 'Modules' . DS . 'Mail.php');

class Core
{
  private static $Config;

	public static function Init()
	{
		// Set default charset
		ini_set('default_charset', L_CHARSET);
		// turns on the output compression
		ini_set('zlib.output_compression', 'On');

		self::parseConfig();

		Session::Init();
		Router::Init();
	}


	public static function connectDB()
	{
		global $Db;

		if($Db == null)
		{
			$Db = new Database(self::$Config['DATABASE']['HOST'],
							self::$Config['DATABASE']['PORT'],
							self::$Config['DATABASE']['USER'], self::$Config['DATABASE']['PASS'],
							self::$Config['DATABASE']['NAME']);
			$Db->startDb();
			unset(self::$Config['DATABASE']);
		}

	}

	public static function requireController($controllerName, $params)
	{
		$fi = LD_MODS_COMP . 'Controllers' . DS . L_ENVIRON . '.'. $controllerName . '.php';

		if (file_exists($fi))
			include_once ($fi);
		else
			error('Application.Control.GetController(' . $controllerName . ', $params)',
						'Required controller not found: <br />' . $fi);
		$cClass = str_replace('.', '', $controllerName) . 'Controller';
		new $cClass($params);

	}

	public static function requireDataClass($dataClass)
	{
		$fi = LD_MODS_COMP . 'DataClasses' . DS . 'Data.' . $dataClass . '.php';
		if (file_exists($fi))
			include_once($fi);
		else
			error('Application.Environment.Function.requireDataClass(' . $dataClass . ')',
	          'Required Data Class not found: <br />' . $fi);
		//$mClass = $dataClass . 'Data';
	}

	// reads the configuration
	public static function readConfig($cd)
	{
		list($kind, $key) = explode('/', $cd);
		if($kind == 'DATABASE')
			return null;
		return isset(self::$Config[$kind][$key]) ? self::$Config[$kind][$key] : null;
	}

	// transfer configuration to a private array what is accessed via readConfig(key);
	private static function parseConfig()
	{
		global $LCONFIG;
		self::$Config = $LCONFIG;
		unset($LCONFIG);
	}
}
