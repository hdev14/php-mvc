<?php

namespace App\Interfaces;

interface ModelInterface
{

	public function save();

	public function delete();

	public function update(); 

	public function findOne($params);
	
	public function findAll($params = []);

}

