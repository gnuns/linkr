<?php

class Control
{
  private static $params = array();

  public static function loadParamMap(array $mapedParams, $slashParams)
  {
		if($slashParams != null)//
		{
			$lastRequiredInput = false;
			foreach($slashParams as $pNumber => $pName)
			{
				if(array_key_exists($pName, $mapedParams) &&
					!$lastRequiredInput &&
					!array_key_exists($pName, self::$params))
				{
					if($mapedParams[$pName] == true && isset($slashParams[intval($pNumber) + 1]))
					{
						self::$params[$pName] = escape($slashParams[intval($pNumber) + 1]);
						$lastRequiredInput = true;
					} else {
						self::$params[$pName] = true;
						$lastRequiredInput = false;
					}
				}
				else {
					$lastRequiredInput = false;
				}
			}
		}
  }

  public static function getParam($param)
  {
    if(array_key_exists($param, self::$params)) {
      return self::$params[$param];
    }
    return false;
  }
}
