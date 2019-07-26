<?php

use Storage\Struct;
use function Helpers\Generics\dd;

$response = unserialize($_SESSION['response']);

?>

<h1> <?= $response->home ?? 'home' ?> </h1>