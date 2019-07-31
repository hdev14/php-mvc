<?php


namespace Helpers\Request; 

use Exception;
use function Helpers\Generics\dd;

function load() 
{
	// Pegar o primeiro parâmetro do array get no formato controller=method_name e instancia o controller e chama o method.
	$controller = "\App\Controllers\\" . ucwords(key($_GET));
	$method = current($_GET);

	if (class_exists($controller)) {

		try {

			$page = callControllerMethod($controller, $method);
			return $page;

		} catch (Exception $e) {
			dd($e->getMessage() . " COD: " . $e->getCode());
		}
		
	}
}

function callControllerMethod($controller, $method)
{
	$c = new $controller();
	if (method_exists($c, $method)) {
		
		if (getRequest() === 'POST') {
			$post_methods = $c->configs()['POST'];
			$post_method = tryToCallerPostMethod($post_methods, $method);
			return $c->{$post_method}();
		}

		// GET
		return $c->$method();
	}

	$routes = $c->configs()['routes'];
	$prefix_method = tryToCallerPrefixMethod($routes, $method);
	return $c->{$prefix_method}();
}

function tryToCallerPostMethod($post_methods, $method)
{
	if (array_key_exists($method, $post_methods)) {
		return $post_methods[$method];
	}

	throw new Exception("404 NOT FOUND", 1);
}

function tryToCallerPrefixMethod($routes, $method)
{
	if (array_key_exists($method, $routes)) {
		return $routes[$method];
	}

	throw new Exception("404 NOT FOUND", 2);
}

function getRequest()
{
	if ($_SERVER['REQUEST_METHOD'] === 'GET') return 'GET';

	return 'POST';
}



