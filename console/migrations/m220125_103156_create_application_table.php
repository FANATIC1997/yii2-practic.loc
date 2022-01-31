<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application}}`.
 */
class m220125_103156_create_application_table extends Migration
{
	public function safeUp()
	{
		$this->createTable('{{%application}}', [
			'id' => $this->primaryKey(),
			'theme' => $this->string()->notNull(),
			'description' => $this->string()->notNull(),
			'organization_id' => $this->integer()->notNull(),
			'user_id' => $this->integer()->notNull(),
			'manager_id' => $this->integer()->notNull(),
			'status_id' => $this->integer()->notNull(),
		]);

		// Добавляем foreign key
		$this->addForeignKey(
			'idOrg',  // это "условное имя" ключа
			'{{%application}}', // это название текущей таблицы
			'organization_id', // это имя поля в текущей таблице, которое будет ключом
			'organization', // это имя таблицы, с которой хотим связаться
			'id', // это поле таблицы, с которым хотим связаться
			'NO ACTION',
			'CASCADE',
		);

		$this->addForeignKey(
			'idUser',
			'{{%application}}',
			'user_id',
			'user',
			'id',
			'CASCADE',
			'CASCADE',
		);

		$this->addForeignKey(
			'idManager',
			'{{%application}}',
			'manager_id',
			'user',
			'id',
			'NO ACTION',
			'CASCADE',
		);

		$this->addForeignKey(
			'idStatus',
			'{{%application}}',
			'status_id',
			'status',
			'id',
			'NO ACTION',
			'CASCADE',
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropForeignKey(
			'idOrgAp',
			'{{%application}}'
		);

		$this->dropForeignKey(
			'idUser',
			'{{%application}}'
		);

		$this->dropForeignKey(
			'idManager',
			'{{%application}}'
		);

		$this->dropForeignKey(
			'idStatus',
			'{{%application}}'
		);

		$this->dropTable('{{%application}}');
	}
}
