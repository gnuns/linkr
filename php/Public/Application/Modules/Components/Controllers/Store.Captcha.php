<?php
class CaptchaController extends Control {

  private static $vowels = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');

  public function __construct($params = null) {
    parent::loadParamMap(array( 'gen' => false, 'dbg' => false), $params);
    if(parent::getParam('gen'))
    {
      header('Content-type: application/json');
      echo self::createNewCaptcha();
    }
    /*else if(parent::getParam('dbg')){
      self::createNewCaptcha();
      //header("Content-type: image/png");
      echo '<style>body {background:#191919;}</style><center><img src="data:image/png;base64,' . base64_encode(self::genImage())
      .'"></center>';
      unset($_SESSION['CAPTCHA_WORD']);
    }*/
    else {
      //self::createNewCaptcha();
      header("Content-type: image/png");
      echo self::genImage();
      unset($_SESSION['CAPTCHA_WORD']);
      unset($_SESSION['CAPTCHA_QUESTION']);
    }
  }

  /**
   * Generates a simple captcha
   * @returns String JSon code with captcha data
   */
  public static function createNewCaptcha()
  {
    //$verHash = '';

    $method = 1;//rand(1,2);
    switch($method) {
      case 0: {
        $r1 = rand(1, 9) * 10;
        $r2 = rand(10, 99);
        $_SESSION['CAPTCHA_WORD']  = "UM + NOVE";
        $_SESSION['CAPTCHA_RESPONSE']  = $r1 + $r2;
        $_SESSION['CAPTCHA_QUESTION']  = '           Qual o resultado da soma?';
        break;
      }
      case 1: {
        /*$randomString = strtolower(substr(str_shuffle("AEIOU"), 0, 1)) .
        strtolower(substr(str_shuffle("abcdefghijklmnopqrstuvwxyzAABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4)) .
        strtolower(substr(str_shuffle("AEIOU"), 0, 1));
        $_SESSION['CAPTCHA_WORD']  = strtoupper($randomString);
        $_SESSION['CAPTCHA_RESPONSE']  = 'vish';
        $_SESSION['CAPTCHA_QUESTION']  = '           Qual o resultado da soma?';*/
        $r1 = rand(1, 9) * 10;
        $r2 = rand(10, 99);
        $num = array(
            1 => 'um',
            2 => 'dois',
            3 => 'III',
            4 => 'IV',
            5 => 'cinco',
            6 => 'seis',
            7 => 'SE7E',
            8 => 'oito',
            9 => 'nove',
            10 => 'dez',
          );

        $r1 = rand(1, 10);
        $r2 = rand(1, 10);

        $_SESSION['CAPTCHA_WORD']  = '' . $num[$r1] . " + " . strtoupper($num[$r2]);
        $_SESSION['CAPTCHA_RESPONSE']  = $r1 + $r2;
        $_SESSION['CAPTCHA_QUESTION']  = '      Qual o resultado da soma?';
        break;
      }
      /*case 1: {

        $resol =  strlen($randomString) - strlen(str_replace(self::$vowels, '', $randomString));
        $_SESSION['CAPTCHA_QUESTION']  = '           Quantas NÃO são consoantes?';//. $lulz;

        $randOne = rand(100,999);
        $verHash = $randOne . '#' . strtoupper(substr(sha1(($resol * 3) . $randOne), 10, 20));
        break;
      }*/
    }
//'data:image/png;base64,' . base64_encode(self::genImage())
    $r = array(//'hash' => $verHash,
      'img' => 'http://' . $_SERVER["SERVER_NAME"] . '/captcha.png?_g' . (time() * rand(2, 7) - rand(999, 2000) . rand(10, 99)));
      return json_encode($r);
  }

  public static function genImage() {
    $fonts = array(
      //0 => 'BrokenGlass.ttf#45#60', // OK
      //1 => 'BTTF.ttf#20#50', // OK
      //2 => 'CHLORINP.TTF#25#10',
      2 => 'Fluox___.ttf#25#50', // OK
      3 => 'HACKED.ttf#20#50', // OK
      4 => 'MarioLuigi2.ttf#25#52', // OK
      5 => 'Nervous.ttf#28#15', // OK
      6 => 'newSlendermanswriting.ttf#32#15', //OK
      //8 => 'PostinkantajaJob.ttf#32#35',
      7 => 'Volter.ttf#22#22', // OK
      //8 => 'zeldadxt.ttf#30#0', // OK
      //11 => 'ASS.TTF#40#28', // NOPE
      8 => 'LAKERG__.TTF#31#15', // OK
      9 => 'VEGETABLE.TTF#28#15', // OK
      //14 => 'The_quick_monkey.ttf#40#25',
      10 => 'Maybe Maybe Not.ttf#25#25', // OK
      //16 => 'caricature.ttf#40#-10'
    );
    ob_start();
      //
      $im = imagecreatetruecolor(320, 100);
      // Transparent Background
      imagealphablending($im, false);
      $transparency = imagecolorallocatealpha($im, 0, 0, 0, 127);
      imagefill($im, 0, 0, $transparency);
      imagesavealpha($im, true);

      $font = explode('#', $fonts[rand(2, 10)]);

      $fg_q = imagecolorallocate($im, 255,255,255);
      $fg = imagecolorallocate($im, 34, 168, 108);
      // Replace path by your own font path
      imagettftext($im, $font[1], (rand(-3, 0)), $font[2], 45, $fg, LD_MODS_COMP . 'Extra'. DS .
      'CaptchaFonts' . DS . $font[0],
       @$_SESSION['CAPTCHA_WORD']);
      imagettftext($im, 12, 0, 10, 80, $fg_q, LD_MODS_COMP . 'Extra'. DS .
      'Strait.ttf', @$_SESSION['CAPTCHA_QUESTION']);

imagesavealpha($im, true);

$transparent = imagecolorallocatealpha($im, 0, 0, 0, 127);
      imagepng($im);
      imagedestroy($im);
      $theImg = ob_get_contents();
    ob_end_clean();
    return $theImg;

  }
}
