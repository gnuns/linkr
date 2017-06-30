<?php

class ErrorController
{
	public function __construct($params)
	{
		$eCode = $params[0];
		switch ($eCode) {
			case '404':
				$this->e404();
				break;

			default:
				header('Location: '.Core::readConfig('SITE/WWW').'/index.php');
				break;
		}
	}
	public function e404()
	{
		echo "ERRO 404!";
	}
}
