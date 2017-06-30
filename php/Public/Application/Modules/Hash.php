<?php

define("PBKDF2_HASH_ALGORITHM", "sha256");
define("PBKDF2_ITERATIONS", 1000);
define("PBKDF2_SALT_BYTE_SIZE", 24);
define("PBKDF2_HASH_BYTE_SIZE", 24);

define("HASH_SECTIONS", 2);
define("HASH_SALT_INDEX", 0);
define("HASH_PBKDF2_INDEX", 1);

class HashLib
{

	public static function getCookieID($uID)
	{
		$h = ('LINKR-U-' . strtoupper(sha1($uID .'1!NKr-10:23*'.$uID . '*')));
		return $h;
	}

	public static function getSSHASH($userName, $userPWD, $userLastLogin = 0)
	{
		$SS = sha1(str_rot13($userPWD) . md5('1!nKr!' . USERIP) . strtolower($userName));
		return 'LINKR-'. substr($SS, -32);
	}

	public static function genPwdHash($pwd, $userID)
	{
		$password = $userID . $pwd;
		return self::createHash($password);
	}

	public static function genActivationHash($uid)
	{
		return (substr(md5(7 * rand(128, 256)), 1, 6) . '.' . rand(0, 9) . substr(hash('whirlpool', base64_encode(rand(33, 1616) . $uid)), 0, 27));
	}

	
	public static function comparePwdHash($userID, $pwd, $correctHash) 
	{
		return self::validatePassword($userID . $pwd, $correctHash);
	}
	
	/*
	 * Password Hashing With PBKDF2 (http://crackstation.net/hashing-security.htm).
	 * Copyright (c) 2013, Taylor Hornby
	 * All rights reserved.
	 *
	 * Redistribution and use in source and binary forms, with or without 
	 * modification, are permitted provided that the following conditions are met:
	 *
	 * 1. Redistributions of source code must retain the above copyright notice, 
	 * this list of conditions and the following disclaimer.
	 *
	 * 2. Redistributions in binary form must reproduce the above copyright notice,
	 * this list of conditions and the following disclaimer in the documentation 
	 * and/or other materials provided with the distribution.
	 *
	 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
	 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
	 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
	 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
	 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
	 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
	 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
	 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
	 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
	 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
	 * POSSIBILITY OF SUCH DAMAGE.
	 */

	// These constants may be changed without breaking existing hashes.

	private static function createHash($password)
	{
		// format: algorithm:iterations:salt:hash
		$salt = base64_encode(mcrypt_create_iv(PBKDF2_SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM));
		return $salt . ":" .
				base64_encode(self::pbkdf2(
						PBKDF2_HASH_ALGORITHM,
						$password,
						$salt,
						PBKDF2_ITERATIONS,
						PBKDF2_HASH_BYTE_SIZE,
						true
				));
	}

	private static function validatePassword($password, $correct_hash)
	{
		$params = explode(":", $correct_hash);
		if(count($params) < HASH_SECTIONS)
			 return false;
		$pbkdf2 = base64_decode($params[HASH_PBKDF2_INDEX]);
		return self::slowEquals(
				$pbkdf2,
				self::pbkdf2(
						PBKDF2_HASH_ALGORITHM,
						$password,
						$params[HASH_SALT_INDEX],
						intval(PBKDF2_ITERATIONS),
						strlen($pbkdf2),
						true
				)
		);
	}

	// Compares two strings $a and $b in length-constant time.
	private static function slowEquals($a, $b)
	{
		$diff = strlen($a) ^ strlen($b);
		for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
		{
			$diff |= ord($a[$i]) ^ ord($b[$i]);
		}
		return $diff === 0;
	}

	/*
	 * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
	 * $algorithm - The hash algorithm to use. Recommended: SHA256
	 * $password - The password.
	 * $salt - A salt that is unique to the password.
	 * $count - Iteration count. Higher is better, but slower. Recommended: At least 1000.
	 * $key_length - The length of the derived key in bytes.
	 * $raw_output - If true, the key is returned in raw binary format. Hex encoded otherwise.
	 * Returns: A $key_length-byte key derived from the password and salt.
	 *
	 * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
	 *
	 * This implementation of PBKDF2 was originally created by https://defuse.ca
	 * With improvements by http://www.variations-of-shadow.com
	 */
	private static function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
	{
		$algorithm = strtolower($algorithm);
		if(!in_array($algorithm, hash_algos(), true))
			trigger_error('PBKDF2 ERROR: Invalid hash algorithm.', E_USER_ERROR);
		if($count <= 0 || $key_length <= 0)
			trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);

		if (function_exists("hash_pbkdf2")) {
			// The output length is in NIBBLES (4-bits) if $raw_output is false!
			if (!$raw_output) {
					$key_length = $key_length * 2;
			}
			return hash_pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output);
		}

		$hash_length = strlen(hash($algorithm, "", true));
		$block_count = ceil($key_length / $hash_length);

		$output = "";
		for($i = 1; $i <= $block_count; $i++) {
			// $i encoded as 4 bytes, big endian.
			$last = $salt . pack("N", $i);
			// first iteration
			$last = $xorsum = hash_hmac($algorithm, $last, $password, true);
			// perform the other $count - 1 iterations
			for ($j = 1; $j < $count; $j++) {
					$xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
			}
			$output .= $xorsum;
		}

		if($raw_output)
			return substr($output, 0, $key_length);
		else
			return bin2hex(substr($output, 0, $key_length));
	}

}