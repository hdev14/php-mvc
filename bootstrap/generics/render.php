<?php

function render(string $view, array $params = []) 
{
	if (!$view) {
		throw new Error("ERROR function render() : first parameter is required !");
	}

	$page = "views/$view" . ".php";

	if (!file_exists($page)) {
		throw new Erro ("Error function render() : view doesn't exist !");
	}

	return $page;
}
