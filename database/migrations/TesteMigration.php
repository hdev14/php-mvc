<?php

namespace Database\Migrations;

use Database\Migrations\AbstractMigration;

class TesteMigration extends AbstractMigration
{
	public function up() : bool
	{	
		
		$this->id = $this->setParams('INT', ['PRIMARY KEY']);
		$this->name = $this->setParams('VARCHAR(45)', ['NOT NULL']);

		return $this->createTable('model');
	}

	public function down() : bool
	{
		return $this->dropTable('model');
	}

}
