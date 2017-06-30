<?php

class LogoutController extends Control
{
	public function __construct($params = null)
	{
		if(Session::isLoggedIn())
		{
			// TODO: A BEAUTIFUL LOGOUT PAGE
			Session::destroyUserSession();
		}
		header('Location: ' . './');
		exit;
	}
}
