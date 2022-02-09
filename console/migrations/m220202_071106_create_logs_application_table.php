<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%logs_application}}`.
 */
class m220202_071106_create_logs_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%logs_application}}', [
            'id' => $this->primaryKey(),
            'application_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'old_user_id' => $this->integer()->Null()->defaultValue(null),
            'old_manager_id' => $this->integer()->Null()->defaultValue(null),
            'create_time' => $this->timestamp()->notNull(),
            'update_time' => $this->timestamp()->notNull(),
            'comment' => $this->string()->notNull(),
        ]);

		$this->addForeignKey(
			'ap',
			'{{%logs_application}}',
			'application_id',
			'application',
			'id',
			'CASCADE',
			'CASCADE',
		);

		$this->addForeignKey(
			'st',
			'{{%logs_application}}',
			'status_id',
			'status',
			'id',
			'NO ACTION',
			'NO ACTION',
		);

		$this->addForeignKey(
			'u',
			'{{%logs_application}}',
			'user_id',
			'user',
			'id',
			'NO ACTION',
			'CASCADE',
		);

		$this->addForeignKey(
			'o_u',
			'{{%logs_application}}',
			'old_user_id',
			'user',
			'id',
			'NO ACTION',
			'CASCADE',
		);

		$this->insert('{{%logs_application}}', [
			'id' => 1,
			'application_id' => 1,
			'status_id' => 1,
			'user_id' => 5,
			'create_time' => new Expression('NOW()'),
			'update_time' => new Expression('NOW()'),
			'comment' => 'Создание заявки',
		]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 2,
		    'application_id' => 2,
		    'status_id' => 1,
		    'user_id' => 2,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 3,
		    'application_id' => 3,
		    'status_id' => 1,
		    'user_id' => 5,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 4,
		    'application_id' => 4,
		    'status_id' => 1,
		    'user_id' => 2,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 5,
		    'application_id' => 5,
		    'status_id' => 1,
		    'user_id' => 3,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 6,
		    'application_id' => 6,
		    'status_id' => 1,
		    'user_id' => 3,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 7,
		    'application_id' => 7,
		    'status_id' => 1,
		    'user_id' => 3,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 8,
		    'application_id' => 8,
		    'status_id' => 1,
		    'user_id' => 4,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 9,
		    'application_id' => 9,
		    'status_id' => 1,
		    'user_id' => 4,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 10,
		    'application_id' => 10,
		    'status_id' => 1,
		    'user_id' => 4,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 11,
		    'application_id' => 11,
		    'status_id' => 1,
		    'user_id' => 5,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 12,
		    'application_id' => 12,
		    'status_id' => 1,
		    'user_id' => 2,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 13,
		    'application_id' => 13,
		    'status_id' => 1,
		    'user_id' => 2,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 14,
		    'application_id' => 14,
		    'status_id' => 1,
		    'user_id' => 2,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 15,
		    'application_id' => 15,
		    'status_id' => 1,
		    'user_id' => 3,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 16,
		    'application_id' => 16,
		    'status_id' => 1,
		    'user_id' => 3,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 17,
		    'application_id' => 17,
		    'status_id' => 1,
		    'user_id' => 3,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 18,
		    'application_id' => 18,
		    'status_id' => 1,
		    'user_id' => 4,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 19,
		    'application_id' => 19,
		    'status_id' => 1,
		    'user_id' => 4,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);

	    $this->insert('{{%logs_application}}', [
		    'id' => 20,
		    'application_id' => 20,
		    'status_id' => 1,
		    'user_id' => 4,
		    'create_time' => new Expression('NOW()'),
		    'update_time' => new Expression('NOW()'),
		    'comment' => 'Создание заявки',
	    ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$this->dropForeignKey(
			'ap',
			'{{%logs_application}}'
		);

		$this->dropForeignKey(
			'st',
			'{{%logs_application}}'
		);

		$this->dropForeignKey(
			'u',
			'{{%logs_application}}'
		);

		$this->dropForeignKey(
			'o_u',
			'{{%logs_application}}'
		);

        $this->dropTable('{{%logs_application}}');
    }
}
