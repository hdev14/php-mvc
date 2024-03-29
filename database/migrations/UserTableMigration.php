<?php

namespace Database\Migrations;

use AbstractMigration;

class UserTableMigration extends AbstractMigration
{
	public function up() : bool
	{
		$this->id = $this->setParams('INT', ['PRIMARY KEY', 'AUTOINCREMENT']);
		$this->name = $this->setParams('VARCHAR(45)', ['NOT NULL']);
		$this->email = $this->setParams('VARCHAR(60)', ['UNIQUE', 'NOT NULL']);
		$this->password = $this->setParams('VARCHAR(100)', ['NOT NULL']);

		return $this->createTable('user');
	}

	public function down() : bool
	{
		return $this->dropTable('user');
	}

}
