<?php

namespace App\Model;

use PDO;
use Database\Connection;
use function Helpers\Generics\dd;

class Model
{
	private $db;
	private $data = array();

	public function __construct()
	{
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

	public function findOne(int $id = null, array $params = [])
	{	
		$object = null;
		
		if ($id) {
			$object = self::getById($id)->fetch(PDO::FETCH_CLASS, __CLASS__);
		} elseif($params) {
			$object = self::getByParams($params)->fetch(PDO::FETCH_CLASS, __CLASS__);
		} else {
			throw new ArgumentCountError("ERROR function findOne() : The function require some parameter(id or params)!")
		}

		return $object;
	}

	protected function getById(int $id)
	{	
		$sql = "SELECT * FROM :table WHERE id = :id";
		
		try {
			
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam([':table', strtolower(__CLASS__)]);

			
			return $stmt->execute();

		} catch (PDOException $e) {
			dd("ERROR function getById(): " . $e->getMessage());
		}

		return null;
	}

	protected function getByParams(array $params)
	{
		$prepare_params = array_reduce(array_keys($params), function ($accumulator, $param) {
			return $accumulator += " " . $param . " = :" . $param . " ";
		}, "");

		$sql = "SELECT * FROM :table WHERE " . $prepare_params;

		try {

			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(':table', strtolower(__CLASS__));

			foreach ($params as $key => $value) {
				$stmt->bindParam(':'.$key, $value);
			}

			return $stmt->execute();

		} catch (PDOException $e) {
			dd("ERROR function getByParams(): " . $e->getMessage());
		}

		return null;
	}

}
