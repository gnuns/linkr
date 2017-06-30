<?php

class Router{

	private static $routes = array();
	private static $requestURI = null;

	public static function Init() {
		self::setEnviron();
    self::loadRequestMap();
		self::routeRequests();
	}

  private static function loadRequestMap() {
    switch(L_ENVIRON)
    {
      default:
      case 'Store': {
        self::addToRequestMap('/', 'Home');
		    self::addToRequestMap('/home', 'Home');
		    self::addToRequestMap('/g', 'GamePage');
		    self::addToRequestMap('/404', 'Error.404');
		    self::addToRequestMap('/register', 'Register');
		    self::addToRequestMap('/login', 'Login');
		    self::addToRequestMap('/captcha', 'Captcha');
		    self::addToRequestMap('/captcha.png', 'Captcha');
		    self::addToRequestMap('/logout', 'Logout');
		    self::addToRequestMap('/search', 'Search');
        self::addToRequestMap('/settings', 'Settings');
        self::addToRequestMap('/activate', 'EmailActivation');
        self::addToRequestMap('/confirm', 'EmailActivation');
        self::addToRequestMap('/u', 'Profile');

		    self::addToRequestMap('/info', 'Info');
        break;
      }
      case 'Community': {
        self::addToRequestMap('/', 'Home');
        self::addToRequestMap('/home', 'Home');
        break;
      }
      case 'Publish': {
      	self::addToRequestMap('/', 'Home');
		    self::addToRequestMap('/home', 'Home');
      	self::addToRequestMap('/error', 'Error');
        break;
      }
    }
  }

  private static function addToRequestMap($requestURL, $controller)
  {
		if(!array_key_exists($requestURL, self::$routes))
		{
			self::$routes[$requestURL] = $controller;
		}
	}

  private static function setEnviron()
  {

    self::$requestURI = $_SERVER['REQUEST_URI'];
    self::$requestURI = (startsWith(self::$requestURI, '/')) ? self::$requestURI :
                                                 '/' . self::$requestURI;

    $cur_domain = $_SERVER["HTTP_HOST"];
    if(strpos('loja.'.Core::readConfig('SITE/DOMAIN'), $cur_domain) === 0 /* ||
       strpos('store.'.Core::readConfig('SITE/DOMAIN'), $cur_domain) == true*/)
    {
      define('L_ENVIRON', 'Store');
    }
    else if(strpos('comunidade.'.Core::readConfig('SITE/DOMAIN'), $cur_domain) === 0 /*||
            strpos('community.'.Core::readConfig('SITE/DOMAIN'), $cur_domain) == true*/)
    {
      define('L_ENVIRON', 'Community');
    }
    else if(strpos('publique.'.Core::readConfig('SITE/DOMAIN'), $cur_domain) === 0 /*||
            strpos('publish.'.Core::readConfig('SITE/DOMAIN'), $cur_domain) == true*/)
    {
      define('L_ENVIRON', 'Publish');
    }
    else {
      header('Location: http://loja.'.Core::readConfig('SITE/DOMAIN').self::$requestURI);
    }
  }

	private static function routeRequests()
	{
    //CHECK REQUEST LENGHT. MAX=256
		if(strstr(self::$requestURI, 'index.php') || strlen($_SERVER['REQUEST_URI']) > 256)
		{
			header('Location: /'.Core::readConfig('SITE/WWW'));
			exit;
		}

    self::$requestURI = str_replace(Core::readConfig('SITE/WWW'), '',
                                                self::$requestURI);

    self::$requestURI = explode('?', self::$requestURI);
		self::$requestURI = self::$requestURI[0]; // fuq de ?

    while(strstr(self::$requestURI, '//'))
		{
			self::$requestURI = str_replace('//', '/', self::$requestURI);
		}

		$requestParams = explode('/', self::$requestURI);
		$requestPage = strtolower(startsWith($requestParams[1], '/') ?
                              $requestParams[1] : '/' . $requestParams[1]);
		$requestParams = array_slice($requestParams, 2);

		if(array_key_exists($requestPage, self::$routes))
		{
			if(isset($requestParams[0]) && $requestParams[0] == '')
			{
				$requestParams = null;
			}

			Core::requireController(self::$routes[$requestPage], $requestParams);
		}
		else
		{
			Core::requireController('Error.404', $requestParams);
		}
	}

}
