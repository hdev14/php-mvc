<?php

namespace App\Controllers;

class Controller implements \App\Interfaces\ControllerInterface
{	
	public function configs() {
		return [
			'POST' => [
				'home'
			],
			"routes" => [
				'h' => 'home'
			]
		];
	}

	public function home() {
		// $home = "home";
		return $this->render('home', [
			'home' => 'Home Controller',
		]);
	}

	protected function render(string $view, array $params = []) 
	{	

		if (!$view) {
			throw new \Error("ERROR function render() : first parameter is required !");
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
			throw new \Error("Error function render() : view doesn't exist !");
		}

		return $page;
	}

}
