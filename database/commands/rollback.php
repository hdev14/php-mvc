<?php

echo "Rollback ...";

if (UserTableMigration::down()) {
	echo "Feito";
} else {
	echo "Rollback falhou !";
}



