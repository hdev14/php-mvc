<?php

namespace Database\Migrations;

use Database\Connection;
use PDOException;
use Exception;

abstract class AbstractMigration
{

	private $db;
	private $table = array();
	
	final protected function __construct() 
	{
		$this->db = Connection::getConnection();
	}

	final protected function __set($attribute, $value) {
		$this->table[$column] = $params;
	}

	final protected function setParams(string $type, array $otherParams) : string
	{
		return $type . " " . implode(" ", $otherParams);
	}

	final protected function createTable(string $table_name) : bool 
	{

		if (!isset($this->table)) {
			throw new Exception("A tabela $table_name não contem colunas.");
		}
		
		$arr_columns = array_map(function($column, $params) {
			return $column . " " . $params;	
		}, array_keys($this->table), array_values($this->table));

		$sql = "
			CREATE TABLE IF NOT EXISTS $table_name(
				" . implode(",", $arr_columns) . "			
			)
		";

		try {
			$this->db->exec($sql);
		} catch (PDOException $e) {
			
			echo "ERROR: " . $e->getMessage() 
				. " LINE " . $e->getLine() 
				. " FILE " . $e->getFile();

			return false;
		}

		return true;
	}

	final protected function dropTable(string $table_name) : bool 
	{
		$sql = "DROP TABLE IF EXISTS $table_name";
		
		try {
			$this->db->exec($sql);
		} catch (PDOException $e) {
			
			echo "ERROR: " . $e->getMessage() 
				. " LINE " . $e->getLine() 
				. " FILE " . $e->getFile();

			return false;
		}

		return true;
	}


	abstract protected function up() : bool;
	abstract protected function down() : bool;

}
