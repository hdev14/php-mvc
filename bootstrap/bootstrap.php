<?php

session_start();

require '../vendor/autoload.php';


use Database\Migrations\TesteMigration;

$m = new TesteMigration();

\Helpers\Generics\dd($m->up());

