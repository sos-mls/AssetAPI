<?php 

/**
 * Creates random values from PBKDF2's hasing system and removes unecessary characters from those strings.
 * 
 * @author   <christian.micklisch@successwithsos.edu>
 * @since 	 v0.0.0
 */
class RandomString extends CApplicationComponent {

	/**
	 * Generates the name of a random file based off of the microtime of the server, and a random string 
	 * between 1 to 10,000. The string is then hased by the PBKDF2 hash and all of the uneccesary identifiers 
	 * are also removed.
	 * 
	 * @return string 	A random file name
	 */
	public function file_name() {

		$str = strval(microtime()) . strval(mt_rand(1, 10000));
		return str_replace(':', '_',
			str_replace("/", "_", 
				str_replace("+", "_", 
					str_replace("?", "_", 
						str_replace("=", "_", 
							str_replace("&", "_", 
								str_replace("sha256:1000:", "", Yii::app()->hash->create_hash($str))
							)
						)
					)
				)
			)
		);
	}

	/**
	 * Creates a Random Hash ID for Sales and Businesses.
	 * 
	 * @return string 	A random hash ID
	 */
	public function hash_id() {

		$str = strval(microtime()) . strval(mt_rand(1, 10000));
		return str_replace(":", "",
			str_replace("/", "_", 
				str_replace("+", "_", 
					str_replace("?", "_", 
						str_replace("=", "_", 
							str_replace("&", "_", 
								str_replace("sha256:1000:", "", Yii::app()->hash->create_hash($str))
							)
						)
					)
				)
			)
		);
	}

	/**
	 * Generates a short hash id from Hash ids.
	 * 
	 * @param  int 	$id A positive integer.
	 * @return string 	A hash id from the id given.
	 */
	public function short_hash_id($id, $salt = "") {
		require_once(dirname(__FILE__) . '/../vendor/hashids/hashids/lib/Hashids/HashGenerator.php');
		require_once(dirname(__FILE__) . '/../vendor/hashids/hashids/lib/Hashids/Hashids.php');

		if ($salt === "")
		{
			$salt = Yii::app()->params->short_hash_salt;
		}

		$hashid = new Hashids\Hashids($salt);
		return $hashid->encode($id);
	}
}