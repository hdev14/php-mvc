<?php

session_start();

require '../vendor/autoload.php';


use App\Model\Model;

$m = new Model();

\Helpers\Generics\dd($m->findOne(['id' => 2, 'name' => 'model 2']));

