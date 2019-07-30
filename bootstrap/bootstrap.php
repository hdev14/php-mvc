<?php

session_start();

require '../vendor/autoload.php';

use function Helpers\Generics\dd;

use App\Model\Model;

$m = new Model();

dd($m->findOne(['name' => 'Model 7']));

