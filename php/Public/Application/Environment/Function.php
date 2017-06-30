<?php

//override_function('require', '$f', 'req_override($f);');
function getTime() {
	$array_time = explode(" ", microtime());
	return floatval($array_time[1]) + floatval($array_time[0]);
}

$ts = getTime();

function escape($v) {
	$return = '';
	$value = strval($v);
	for ($i = 0; $i < strlen($value); ++$i) {
		$char = $value[$i];
		$ord = ord($char);
		if ($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126)
			$return .= $char;
		else
			$return .= '\\x' . dechex($ord);
	}
	return strval($return);

}

function descape($value) {
	$res = $value;
	$r = explode('\\x', $res);
	for ($i = 1; $i < count($r); $i++) {
		$res = str_replace('\\x' . substr($r[$i], 0, 2),
											chr(hexdec(substr($r[$i], 0, 2))), $res);
	}
	return htmlentities(strval($res), ENT_QUOTES);
	// ANTI-XSS (:
}

function alphaID($in, $to_num = false, $pad_up = false, $passKey = null) {
	$index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	if ($passKey !== null) {
		// Although this function's purpose is to just make the
		// ID short - and not so much secure,
		// with this patch by Simon Franz (http://blog.snaky.org/)
		// you can optionally supply a password to make it harder
		// to calculate the corresponding numeric ID

		for ($n = 0; $n < strlen($index); $n++) {
			$i[] = substr($index, $n, 1);
		}

		$passhash = hash('sha256', $passKey);
		$passhash = (strlen($passhash) < strlen($index)) ? hash('sha512', $passKey)
									: $passhash;

		for ($n = 0; $n < strlen($index); $n++) {
			$p[] = substr($passhash, $n, 1);
		}

		array_multisort($p, SORT_DESC, $i);
		$index = implode($i);
	}
	$base = strlen($index);

	if ($to_num) {
		// Digital number  <<--  alphabet letter code
		$in = strrev($in);
		$out = 0;
		$len = strlen($in) - 1;
		for ($t = 0; $t <= $len; $t++) {
			$bcpow = bcpow($base, $len - $t);
			$out = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
		}
		if (is_numeric($pad_up)) {
			$pad_up--;
			if ($pad_up > 0) {
				$out -= pow($base, $pad_up);
			}
		}
		$out = sprintf('%F', $out);
		$out = substr($out, 0, strpos($out, '.'));
	} else {
		// Digital number  -->>  alphabet letter code
		if (is_numeric($pad_up)) {
			$pad_up--;
			if ($pad_up > 0) {
				$in += pow($base, $pad_up);
			}
		}

		$out = "";
		for ($t = floor(log($in, $base)); $t >= 0; $t--) {
			$bcp = bcpow($base, $t);
			$a = floor($in / $bcp) % $base;
			$out = $out . substr($index, $a, 1);
			$in = $in - ($a * $bcp);
		}
		$out = strrev($out);
		// reverse
	}

	return $out;
}

function error($from, $text = '') {
	if (L_DEBUG) {
		$html = '
		<html>
			<head>
				<title>[LINK-DEBUG] ERRO!</title>
				<meta charset="utf-8" />
				<style>
					body {
						background-color: #282828;
						color: #ccc;
						font-family: Arial, Helvetica, sans-serif;
						font-size: 12px;
					}
					.center {
						width:500px;
						min-height: 50px;
						display:table;
						margin:auto;
						background-color: #222;
						border:2px dotted #212121;
						padding:20px;
						margin-top:10%;
					}
				</style>
			</head>
			<body>
				<div class="center">
					<p style="color:#CD3333; font-weight: bold;margin-top:0px; margin-bottom: 0px;">Putz cara, erro!</p>
					<p style="color:#EFEFEF; font-weight: bold;margin-top:2px;margin-bottom: 0px;">Método: <span style="color:#AAA">' . $from . '</span></p>
					<p style="color:#EFEFEF; font-weight: bold;margin-top:2px">Descrição:  <span style="color:#AAA">' . $text . '</span></p>
				</div>
				' . genStats() . '
			</body>
		</html>';
		echo $html;
		exit ;
	} else {
		header('Location: ./');
		echo "";
		exit ;
	}
}

function genStats() {
	global $ts;
	$tt = round(abs(getTime() - $ts), 4);
	global $Db;
	return '<div style="font-size: 11px;font-family: Consolas, Arial, Helvetica, '.
	'sans-serif;position: fixed; bottom: 0px; right: 0px;padding:5px;'.
	' background:rgba(0,0,0,0.6)"><strong>[Linkr Debug]</strong> Script Load Time: ' .
	$tt . 's (' . ($tt * 1000) . 'ms) | Memory Load: ' .
	round((memory_get_usage() / 1024 / 1024), 2) . ' MB' .
	(($Db != null) ? ' | QueryCount: ' . $Db -> queryCount() : '') . (isset($_POST) && (count($_POST)) ? ' | Params posted: ' . count($_POST) : '') . '</div>';

}

// http://stackoverflow.com/a/9826656
function getStringBetween($start, $end, $string){
    /*$string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);*/
    $matches = array();
		$delimiter = '#';
    $regex = $delimiter . preg_quote($start, $delimiter)
                    . '(.*?)'
                    . preg_quote($end, $delimiter)
                    . $delimiter
                    . 's';
    preg_match($regex, $string, $matches);
		//print_r($matches[0]);
		return @$matches[1];
}

/*
 * Meio que uma fucking gambiarra.
 * Use com moderação.
 */
function getStringBetweenAll($start, $end, $str){
    $matches = array();
		$delimiter = '#';
    $regex = $delimiter . preg_quote($start, $delimiter)
                    . '(.*?)'
                    . preg_quote($end, $delimiter)
                    . $delimiter
                    . 's';
    preg_match_all($regex, $str, $matches);
    $realResults = array();
    foreach($matches as $k => $v)
		{
			foreach($v as $key => $value) {
				if(!startsWith($value, $start) && !endsWith($value, $end)) {
					$realResults[] = $value;
				}
			}
		}
    return $realResults;
}

function startsWith($haystack, $needle) {
	return $needle === "" || strpos($haystack, $needle) === 0;
}

function endsWith($haystack, $needle) {
	return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

/*
function setCookie($Name, $Value = '', $MaxAge = 0, $Path = '', $Domain = '', $Secure = false, $HTTPOnly = false)
{
  		header('Set-Cookie: ' . rawurlencode($Name) . '=' . rawurlencode($Value)
                        . (empty($MaxAge) ? '' : '; Max-Age=' . $MaxAge)
                        . (empty($Path)   ? '' : '; path=' . $Path)
                        . (empty($Domain) ? '' : '; domain=' . $Domain)
                        . (!$Secure       ? '' : '; secure')
                        . (!$HTTPOnly     ? '' : '; HttpOnly'), false);
}*/

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}