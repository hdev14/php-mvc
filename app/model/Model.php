<?php

namespace App\Model;

use PDO;
use PDOException;
use Database\Connection;
use function Helpers\Generics\dd;

class Model
{
	private $db;
	private $data = array();
	protected $table;

	public function __construct()
	{	
		# \Namespace\Molde => \namespace\model => ['namespace', 'model'] => 'model';
		$this->table = end(explode("\\", strtolower(__CLASS__)));
		$this->db = Connection::getConnection();
	}

	public function __get($attribute)
	{
		return $this->data[$attribute];
	}

	public function __set($attribute, $value) 
	{
		$this->data[$attribute] = $value;
	}

	public function save()
	{
		if (!$this->data) return false;

		$sql = "INSERT INTO " . $this->table . "(" . implode(", ", array_keys($this->data)) . ") ";
		$sql .= "VALUES (:" . implode(",:", array_keys($this->data)) . ")";

		try {

			$stmt = $this->db->prepare($sql);

			foreach($this->data as $key => &$value) {
				$stmt->bindParam(":".$key, $value);
			}

			return $stmt->execute();

		} catch (PDOException $e) {
			dd("ERROR function save(): " . $e->getMessage() . " LINE " . $e->getLine());
		}
	}

	public function delete() 
	{
		if (!$this->data) return false;

		$sql = "DELETE FROM " . $this->table . " WHERE id = :id";

		try {

			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":id", $this->id);
			return $stmt->execute();

		} catch (PDOException $e) {
			dd("ERROR function delete(): " . $e->getMessage() . " LINE " . $e->getLine());	
		}
	}

	public function update() 
	{
		if (!$this->data) return false;

		$prepare_params = self::prepareParams($this->data);

		unset($prepare_params['id']);

		$sql = "UPDATE " . $this->table . " SET " . implode(", ", $prepare_params). " WHERE id = :id ";

		try {

			$stmt = $this->db->prepare($sql);

			foreach ($this->data as $key => &$value) {
				$stmt->bindParam(":" . $key, $value);
			}

			return $stmt->execute();

		} catch(PDOException $e) {
			dd("ERROR function update(): " . $e->getMessage() . " LINE " . $e->getLine());
		}
	}

	public function findOne($params) // ID ou um array de parametros.
	{	
		$object = null;
		
		if (!is_array($params)) {
			$object = self::getById($params)->fetchObject(__CLASS__);
		} elseif ($params) { // Verificação do array, caso seja passado um array inválido.
			$object = self::getByParams($params)->fetchObject(__CLASS__);
		} else {
			throw new ArgumentCountError("ERROR function findOne() : The function require some parameter(id or params)!");
		}

		return $object;
	}

	public function findAll($params = [])
	{
		$objects = null;

		if ($params) {
			$objects = self::getByParams($params)->fetchAll(PDO::FETCH_CLASS, __CLASS__);
		} else {
			$objects = self::getByParams($params)->fetchAll(PDO::FETCH_CLASS, __CLASS__);
		}

		return $objects;

	}

	protected function getById(int $id)
	{	

		$sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
		
		try {
			
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			return $stmt;

		} catch (PDOException $e) {
			dd("ERROR function getById(): " . $e->getMessage() . " LINE " . $e->getLine());
		}

		return null;
	}

	protected function getByParams(array $params = [])
	{	
		
		if ($params) {

			$prepare_params = self::prepareParams($params);
			$sql = "SELECT * FROM " . $this->table . " WHERE " . implode(" AND ", $prepare_params);
		
		} else {
			$sql = "SELECT * FROM " . $this->table;
		}
	
		try {

			$stmt = $this->db->prepare($sql);

			foreach ($params as $key => &$value) {
				$stmt->bindParam(":" . $key, $value);
			}

			$stmt->execute();

			return $stmt; 

		} catch (PDOException $e) {
			dd("ERROR function getByParams(): " . $e->getMessage() . " LINE " . $e->getLine());
		}

		return null;
	}

	protected function prepareParams($params)
	{
		return array_reduce(array_keys($params), function($accumulator, $param) {
			$accumulator[$param] = $param . " = :". $param . " ";
			return $accumulator;
		}, []);
	} 

}
