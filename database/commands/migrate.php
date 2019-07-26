<?php

use Database\Migrations\UserTableMigration;

$user_table = new UserTableMigration();

echo "Migrando...";

if ($user_table->up()) {
	echo "Feito";
} else {
	echo "Migração falhou !";
}
