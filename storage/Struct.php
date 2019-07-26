<?php

namespace Storage;

class Struct
{
	private $data = array();

	public function __get($attribute)
	{
		return isset($this->data[$attribute]) ? $this->data[$attribute] : null;
	}

	public function __set($attribute, $value)
	{
		$this->data[$attribute] = $value;
	}	
}
