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
			'description' => $this->text()->notNull(),
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

		$this->insert('{{%application}}', [
			'id' => 1,
			'theme' => 'Тема1',
			'description' => 'Описание1',
			'organization_id' => 1,
			'user_id' => 5,
			'manager_id' => 9,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 2,
			'theme' => 'Тема2',
			'description' => 'Описание2',
			'organization_id' => 2,
			'user_id' => 2,
			'manager_id' => 6,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 3,
			'theme' => 'Тема3',
			'description' => 'Описание3',
			'organization_id' => 3,
			'user_id' => 5,
			'manager_id' => 9,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 4,
			'theme' => 'Тема4',
			'description' => 'Описание4',
			'organization_id' => 4,
			'user_id' => 2,
			'manager_id' => 10,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 5,
			'theme' => 'Тема5',
			'description' => 'Описание5',
			'organization_id' => 5,
			'user_id' => 3,
			'manager_id' => 7,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 6,
			'theme' => 'Тема6',
			'description' => 'Описание6',
			'organization_id' => 6,
			'user_id' => 3,
			'manager_id' => 7,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 7,
			'theme' => 'Тема7',
			'description' => 'Описание7',
			'organization_id' => 7,
			'user_id' => 3,
			'manager_id' => 8,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 8,
			'theme' => 'Тема8',
			'description' => 'Описание8',
			'organization_id' => 8,
			'user_id' => 4,
			'manager_id' => 8,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 9,
			'theme' => 'Тема9',
			'description' => 'Описание9',
			'organization_id' => 9,
			'user_id' => 4,
			'manager_id' => 8,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 10,
			'theme' => 'Тема10',
			'description' => 'Описание10',
			'organization_id' => 10,
			'user_id' => 4,
			'manager_id' => 10,
			'status_id' => 1,
		]);


		$this->insert('{{%application}}', [
			'id' => 11,
			'theme' => 'Тема11',
			'description' => 'Описание11',
			'organization_id' => 1,
			'user_id' => 5,
			'manager_id' => 5,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 12,
			'theme' => 'Тема12',
			'description' => 'Описание12',
			'organization_id' => 2,
			'user_id' => 2,
			'manager_id' => 9,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 13,
			'theme' => 'Тема13',
			'description' => 'Описание13',
			'organization_id' => 3,
			'user_id' => 2,
			'manager_id' => 9,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 14,
			'theme' => 'Тема14',
			'description' => 'Описание14',
			'organization_id' => 4,
			'user_id' => 2,
			'manager_id' => 7,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 15,
			'theme' => 'Тема15',
			'description' => 'Описание15',
			'organization_id' => 5,
			'user_id' => 3,
			'manager_id' => 10,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 16,
			'theme' => 'Тема16',
			'description' => 'Описание16',
			'organization_id' => 6,
			'user_id' => 3,
			'manager_id' => 10,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 17,
			'theme' => 'Тема17',
			'description' => 'Описание17',
			'organization_id' => 7,
			'user_id' => 3,
			'manager_id' => 9,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 18,
			'theme' => 'Тема18',
			'description' => 'Описание18',
			'organization_id' => 8,
			'user_id' => 4,
			'manager_id' => 8,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 19,
			'theme' => 'Тема19',
			'description' => 'Описание19',
			'organization_id' => 9,
			'user_id' => 4,
			'manager_id' => 8,
			'status_id' => 1,
		]);

		$this->insert('{{%application}}', [
			'id' => 20,
			'theme' => 'Тема20',
			'description' => 'Описание20',
			'organization_id' => 10,
			'user_id' => 4,
			'manager_id' => 9,
			'status_id' => 1,
		]);
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
