<?php

namespace Helpers\Database;

use function Helpers\Generics\dd;

function database()
{
	return include(__DIR__ . '/../../database/config.php');
}

