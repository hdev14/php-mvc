<?php


namespace Helpers\Request; 
	
function load() 
{
	// Pegar o primeiro parâmetro do array get no formato controller=method_name e instancia o controller e chama o method.

	// USAR ReflectionClass e $className->{"methodName"}();
	$controller = new \App\Controllers\Controller();

	return $controller->home();

}


