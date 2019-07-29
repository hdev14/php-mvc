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

	protected function getByParams(array $params)
	{	
		
		$prepare_params = array_reduce(array_keys($params), function($accumulator, $param) {
			$accumulator[$param] = $param . " = :". $param . " ";
			return $accumulator;
		}, []);

		$sql = "SELECT * FROM " . $this->table . " WHERE " . implode(" AND ", $prepare_params);

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

}
