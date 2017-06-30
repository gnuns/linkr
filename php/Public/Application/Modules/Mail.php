<?php

define('KEY_MANDRILL', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX');
define('MAIL_FROM', 'sistema@linkr.com.br');
require_once(LD_MODS_3RD . 'Mandrill.php');
class MailLib
{
	public static function generateMailFromTemplate($tpl, $data)
	{
		$content = '';
		$tplFile = LD_MODS_COMP . 'MailTemplates' . DS . 'Mail.' . $tpl . '.mtpl';
		if (is_file($tplFile)) {
			ob_start();
			readfile($tplFile);
			$fCont = ob_get_contents();
			ob_end_clean();
			$content = $fCont;

			foreach ($data as $k => $v)
			{
				$content = str_replace("{" . $k . "}", $v, $content);
			}
			return $content;
		}

	}
	public static function sendMail($template, $mailSubj, $toMail, $toName,  $data, $tag, $attachments = null)
	{
		try {
		    $mandrill = new Mandrill(KEY_MANDRILL);
		    $message = array(
		        'html' => self::generateMailFromTemplate($template, $data),
		        //'text' => 'Example text content',
		        'subject' => $mailSubj,
		        'from_email' => MAIL_FROM,
		        'from_name' => 'Linkr',
		        'to' => array(
		            array(
		                'email' => $toMail,
		                'name' => $toName,
		                'type' => 'to'
		            )
		        ),
		        'headers' => array('Reply-To' => 'oi@linkr.com.br'),
		        'important' => true,
		        'track_opens' => null,
		        'track_clicks' => null,
		        'auto_text' => null,
		        'auto_html' => null,
		        'inline_css' => null,
		        'url_strip_qs' => null,
		        'preserve_recipients' => null,
		        'view_content_link' => null,
		        'bcc_address' => null,
		        'tracking_domain' => null,
		        'signing_domain' => null,
		        'return_path_domain' => null,
		        'merge' => true,
		        'merge_language' => 'mailchimp',
		        'global_merge_vars' => array(),
		        'merge_vars' => array(),
		        'tags' => array($tag),
		        //'subaccount' => 'customer-123',
		        'google_analytics_domains' => array('linkr.com.br'),
		        'google_analytics_campaign' => '',
		        'metadata' => array('website' => 'www.linkr.com.br'),
		        'recipient_metadata' => array(),
		        'attachments' => $attachments/*array(
		            array(
		                'type' => 'text/plain',
		                'name' => 'myfile.txt',
		                'content' => 'ZXhhbXBsZSBmaWxl'
		            )
		        )*/,
		        'images' => array(
		            array(
		                'type' => 'image/png',
		                'name' => 'IMGFB',
		                'content' => 'iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAAigAAAIoBlCJR2wAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAK9SURBVDiNfZNNaFRXGIafc+65904ySaFNSkEQfxCKsWAxAaG4EYtEi1jEbDS1dOVGaRdZ+AeXUYwpLhqlFBGJZGmEirQ1qChZqkwbUBSaUpAETaKRMaOTm3HunM+F+Zk7uZN3d96P7znvd36UiFCtTGbIvPRm2pXQqsW2iVKtHyoqi5KsQrLj68KbAx0d5epeVQ08dOqPDdrR/UDrkp0qJHDfsc73vSfa/00EZjIZPeW1dilRJwF/OViFQkEd//XYzl4BiQEPn7lxRImcSepyjUPbhhVsallByjcYo0Fg5OkUA4PDFGdnrvf1fPftAvDH7r++EPgb8KphH6V9fjrwFc0f1y/Z6P/RKYJffgcBt77hm8vd+27oTGbICPQnwQB2b1ufCIuiCLElEAEEWwyvHDx40TUvvZl2LWyqdUifr2mOrUfHp7l7b4RVn6V5Nplb8MvlqCH6JH3EOGLbBFWLh2uc2Prq4DDDD0eYu4OYxNqtGln+eVQqiiImJicTYQC2XG4xi482rvVrP8U1Do7+kL4URYRhyPYtLbwpzALwz+NRno5NLQJtudnUStO5ayONaT8GA9j85eoKgMSAABpUdrkxK2HVevEqH4c55oVGSSJwbGKasfHcElhUFkqRpRRZxp7nYjXH0Y+MQrJJt3yuf4hCPsdvp/bF/J8vDPJs4nViYqXNbT2+LrwJPKgsFGcLFPK5xCaxiTaO8fIr/f969UBHRxmlfwCKAMWwNgzA2qVEpRSu7+0JgiDSAOeP7ngCBMWwQOFNbRhAUkDXT127dHr/HQA9bzaVsmdLpXeDLPNrgLm/u5jMS6WvXa47sHfeWwAGQWD7ejp3evXpXY5x39ZMOMdzjJf369Nf9/V07pFgMbiubujr3v9n2NjY5KfSx91U3S1rEaUUoBBBvFTdHb+uoWtt42jT/JiVeg97niwZLZVh3wAAAABJRU5ErkJggg=='
		            ),
		            array(
		                'type' => 'image/png',
		                'name' => 'IMGTW',
		                'content' => 'iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABmJLR0QA/wD/AP+gvaeTAAAC50lEQVQ4jZWUy2tcdRTHP+c3dx7pdCZt0Bgy2vqiD7OyVau7gohQFayPWbhw7aI7BRUTvbRCVdAuXPsPqKGCNAvBBFGoIKKgizSlj5imqWlSmmTuvTP33t/vuJhmnDsZH/3uzvec8/md3+NeoY/8mUulAWdeViNHUX0UuAtQYBnlR0RPN1eCL/36WNzbK73GB9PzdYWPBHb3W6xLF1X1jbefvPd0X6A/o16RhVOieuw/QNmJVD6+b/WeN+t1sQBmMzHAH5/eLgzAueT1ufLsD5uxATg5fflFVV67XZhaS9wIsHHy+PEzsycAxP/66rZSOZkDav8Hks8J1aLH9fWIJAhp3xWIkbRIfsgb2B4fVZUO7M5ynih1NFp2C+zQripP7K7iibIRRFxcjRgo5Pjip0XUqZcWmDDq5Pnupr3D23j14Aij1WIGdv9QicMP7MATJYwijCgP3lFisOQxVC4A4Jx7ySAc7G7caFoqxRyvPDzMU3t2Mry9XVwbLGKtJYwiVLVTPzO7yo2g/RxV3agHjHQDr6y1uLYRM1IpcKBW4UCtQit1JH1gIsKF641OrE4LpnOqt7RrZ5GRSiGz3ZwomrQyMADrsrHQfjZL3ebv1wKW1v/+olJriXom29RKkGQNMbFB+aXbS6xydn6NILakaUoYhn1hADPnbmQNw6IRo1/1Fi6utQhbCWEU9QUBLNyMWbqZzQu5SbOjsvI5yvnuxEbQ4rPvLtFoub6w9aZj8uerWVgu19wb2XEB+HD68guKTIrAobvL7BnKU85v+REBwtxyyNRvf27JeMXCu+8c2Xei03Xy23nfpcl7aRgxVqvw0GiFwZKHEQhiy4XlgF8X1mgmW6c2Xv6bief2P91e8pZ8X03ukXNnXRI/1nef/yCT974ff2b/YRFxGeCm3p+aPWWT9BjOef8KMiYh730ycWTfW91+v4PCnzpfzak9jrPPqlJTpwVQxJgY5Ip43hnbSMb9+lijt/cvwFBHYdmzwK4AAAAASUVORK5CYII='
		            ),
		            array(
		                'type' => 'image/png',
		                'name' => 'IMGYT',
		                'content' => 'iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAAigAAAIoBlCJR2wAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAKJSURBVDiNlZVNSJRBGMd/z7zv7vpRqJVIBGqXEBULlDoEiaJkYRiRUl2iS4eOFV2Ewi4SRUiXIIjy0NdCWkSkll9Rh0IjMiwjabFTVn6E7K677zvTwY90PzT/l4F5Zn7Pf2aemRFjDLHqq6iwc3O8NcroUhHKjJFSAIQBYEAMA3kmsxO/342dK7HAsWM1RdroVgylcZmW643R1vGt/mcjiYFNTSow/PoswkXAtwpsQSFEGvPvd7UwD1ILkcCnV+cQLq0BBpAadd2r7+vKHy5zOHpkb7GFGQS8a4AR1ZqJcARtDOkee19JW2+H6quosC10axxMhIzaeuzsnKSw3/MwgFlX+2losKzzu7btFzgTO8HKyCKnsZn11bUon4/I1xGM4wAQ0ZqJ8CxLz1Mb45tUs7NKCWUJLYjMNR4vGQePsqXlFuvKq4loEwdbkKvdSiVGr1Yec44zN5B18jSbr99jY1VtwjFaU6QWi3YVua5LMBTCeH3knDhFwbXboKxlYxxjsu3/gTmuSygUItGtipU9f50OrAQLBoP/OqIRfty5ya+uJ/EwJeM2JAc6jkMwFAJAMEy/7Ob7jRbQOmFyS2TIFsOAkfhg1ONdhEVGvxC40kR0ejLZQuYcijy380xmZ0BNvcWwcyEQdl2mAt9I/zDI+KMHzHz+uCIIwKPkT/F2WsQYw1hDVaFW6h3gC7suk+HIqoClEiDN9lSVtPd0K4Bc/4thhAthZ+0wgBSP1V7S3tMNS16b/ILdl8OOfppgO1d0lmrbj3e09x9e7IutraFDlXVh17nraJO2Esyj1IzXUvUlbb0dy5Ik+QJSsjJp1Ebv0VDgaL0JwBL1U4kM2yL9tie7udDvj9ufv/94ISCGApjoAAAAAElFTkSuQmCC'
		            ),
					array(
		                'type' => 'image/png',
		                'name' => 'LOGO',
		                'content' => 'iVBORw0KGgoAAAANSUhEUgAAAGEAAAAlCAYAAABSz4fZAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAK6wAACusBgosNWgAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMS8wMS8xNNLKfncAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzbovLKMAAAE4ElEQVRoge2bQW7bRhSGvym6LBDdwNSqS7knEH2CaFl0Q2ZRSDsrJwh9Ass7Cg0Qspsu6+66C32C0icgcwMbSHcFXhYc2tSEsjjkSFHifgBBcziceeLPmXnvkVYiwlCUUoPbeM4oWxHG6cIHloAPvABugOsyXK9cG/dcsBJhnC5C4N2W07eAX4bru67tiYgPnAIegFJq2dkYh4iIp+2ot2ulVHKo/r/vWlGPgG0CAEyAFRBa9P++8fdNWwUR8ZVSmUWbfQiBN43jfM/9bfCdRd0uT2ngJXOvpy0biMhMRO6A9yJyJyKnLto9RmxE8DvW8+zNaGVFteag99eO2j06bER4sbuKU052HH8z2IjQOme30HlhtuzvL0ftHh02IiQd6tyU4drVojYDUioxUuwW/K+KziIUQZxQ3Yxt3NNt8e6EUupOKRUqpXy9dzXCjg6bkUARxCHwGvhgnPoInDocBc8KKxEAiiBeFUHsAWPgV138A+68omdH52DNpAjiEng7The/6aIlkDmwCXiIYr1GUamUKo06dbRd75v1azIgV0o5c3FFZKT7bJLXU2bjvL/FrhwoqSLzEhEZtHnJPPeSuejN7GzXj2mSGeci43zUOLcSe0oRmW2xY2tfW+pnbbaLSCgiuYVNERgjQacmZlQq5kBWBLHNE/S3l8xjqoReaXGdLX2i5xPgTxG5UEpFfTsWkQSYNopuqe4ZVB7cxKK5DBoijNPFCjhvVJgC5+N0cQPMiiDe8E7G6WJE5bY2O/0RuAQuvWR+BUQ2Cb2B1HFFThWr1FOUeVPeiEjWJx+lBQgaRbeAv8Nzu6Gaekp97Oltqm2tRBiniyWbAjSZAhGfu58ZT6t+zuO8uG/Ott1UqdaNhE1bEywdCRFZYS/AU3aN6mtr72iXf3+un3zgQbQuw27qJfOwQ729oZTKeZwuak7EIiEoIiGbD+k9MCh2aV5bT0dd8jLZOF3UF9rMyRHdou29oZQqRSRl80n26ZCy1gI0U/j3VCPAWUxkEydMqKamKXbJvBNX6e2BZMaxt+uCQwgAjyKYEXAbf2gj+uD1vM4lpXH85Gg+lADwKEK0o95VEcS/FEE8An7q0c/Xls6YcSABQIugk3NXW+qkRRA/LNxFEOfYpZU/HNBN3YqlS2o6Hdm+BIDGmqBv9Bi4aGxnOmlnEln0YVP3WHmpI+HR7qr2bETMOh8U7bqoCOJ8nC5e8fSLf4C0DNdJX+O+IBd633z5PwEyqT48cDqyrbOoNXoKO6MKWkz+BS7KcB32bf9Lo1Mbr4ziWginI6K3CABFEGdFEJ9SLdb/NE79XIbraEjbx4D+9uiMTa9wgsNsMQwUoUa/zPm9UfTRRbvHgF7QfaN4ovNITnAigmao9+C5MGIfaM/InJoCEXHyOteZCGW4zgY2cbIv78MFemp6bRRfSvUp5yCcieAl8yXwnz6MvGTe5Yaai3oi1Ru1o0QpteLzjx2uhz48TkTwkrlP9R6hdnmndPtiLjGOXwKFiJQu7NoTSzYfnsFfB7oaCX5L2bSlzCSh3cU9WnSMEBrF0yHrgysRypaynUlB/YN8qiHedAPb2jsa9EJ9YRRHQK9pyfqfRFobUQovmWc8Pv33QFiGa6thqhe5EXB3gM/hjwZnIsDD2gBQ7vlF/zeFUxH+px+fAKmMj9hvZER4AAAAAElFTkSuQmCC'
		            )

		        )
		    );
		    $async = false;
		    $ip_pool = null;
		    $send_at = '';
		    //$result =
		    $mandrill->messages->send($message, $async, $ip_pool, $send_at);
		    //print_r($result);
		    /*
		    Array
		    (
		        [0] => Array
		            (
		                [email] => recipient.email@example.com
		                [status] => sent
		                [reject_reason] => hard-bounce
		                [_id] => abc123abc123abc123abc123abc123
		            )

		    )
		    */
		} catch(Mandrill_Error $e) {
		    // Mandrill errors are thrown as exceptions
		    //echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
		    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
		    //throw $e;
		}
	}
}
