<?php

use PDO;

class Connection
{

	private static $db;

	public static function getConnection()
	{
		if (isset(self::$db))
			return self::$db;

		self::$db = new PDO('sqlite', '/home/hermerson/Projetos/php-mvc/database/database.sqlite3');
		self::$db->setAttributes(PDO::ATTR_ERRMODE, PDO::ERRMOD_EXCEPTION);
		return self::$db;
		
	}

}
