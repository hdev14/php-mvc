<?php

use Database\Migrations\UserTableMigration;

echo "Rollback ...";

if (UserTableMigration::down()) {
	echo "Feito";
} else {
	echo "Rollback falhou !";
}



