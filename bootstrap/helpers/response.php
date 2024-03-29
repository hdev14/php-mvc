<?php

namespace Helpers\Response; 

use function Helpers\Generics\dd;

function render(string $view, array $params = []) 
{	

	if (!$view) {
		throw new Error("ERROR function render() : first parameter is required !");
	}

	if ($params) {
		
		$response = new \Storage\Struct();

		$result = array_walk($params, function($value, $key) use ($response) {
			$response->{$key} = $value;
		});

		if ($result) {
			$_SESSION['response'] = serialize($response);
		}

	}

	$page = "views/$view" . ".php";

	if (!file_exists($page)) {
		throw new Erro ("Error function render() : view doesn't exist !");
	}

	return $page;
}


