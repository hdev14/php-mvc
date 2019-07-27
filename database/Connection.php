<?php

namespace Database;

use function Helpers\Database\database;
use function Helpers\Generics\dd;
use PDO;
use PDOException;
use Error;

class Connection
{

	private static $db;

	public static function getConnection()
	{
		if (isset(self::$db))
			return self::$db;

		$database = database();

		switch ($database['default']['drive']) {
			case 'sqlite':
				self::$db = self::sqliteConnection($database['default']);
				break;
			case 'mysql':
				self::$db = self::mysqlConnection($database['default']);
				break;
			default:
				throw new Error("Erro no arquivo de configurações.");
				break;
		}

		if (is_null(self::$db)) { die(); }

		self::$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
		self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return self::$db;
		
	}

	private static function sqliteConnection(array $config)
	{	
		try {
			return new PDO('sqlite:' . $config['dbname']);
		} catch(PDOException $e) {
			echo "[ERROR PDO SQLITE] " . $e->getMessage();
		} 

		return null;
	}

	private static function mysqlConnection(array $config)
	{
		try {
			
			return new PDO(
				"mysql:host=" . $config['host'] . ';dbname=' . $config['dbname'],
				$config['username'],
				$config['password']
			);

		} catch(PDOException $e) {
			echo "[ERROR PDO MYSQL] " . $e->getMessage();
		}

		return null;
	}


}
