<?php

abstract class AbstractMigration
{

	private $db;
	
	final protected function __construct() 
	{
		$this->db = Connection::getConnection();
	}

	final protected function createTable(string $table_name, array $columns) : bool 
	{

		function addColumns($column, $attributes) 
		{
			return $column . " " . $attributes;	
		}

		$arr_columns = array_map('addColumns', array_keys($columns), array_values($columns));

		$sql = "
			CREATE TABLE IF NOT EXISTS $table_name(
				" . implode(",", $arr_columns) . "			
			)
		";

		try {
			$this->db->exec($sql);
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}

		return true;
	}

	final protected function dropTable(string $table_name) : bool 
	{
		$sql = "DROP TABLE IF EXISTS $table_name";
		
		try {
			$this->db->exec($sql);
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}

		return true;
	}

	final protected function setAttribute(string $type, array $otherParams) : string
	{
		return $type . " " . implode(" ", $otherParams);
	}

	abstract protected function up();
	abstract protected function down();

}
