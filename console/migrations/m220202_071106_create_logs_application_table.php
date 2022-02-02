<?php

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
            'user_id' => $this->integer()->notNull()->defaultValue(null),
            'old_user_id' => $this->integer()->Null(),
            'created_at' => $this->integer()->notNull(),
            'comment' => $this->string()->notNull(),
        ]);

		$this->addForeignKey(
			'ap',
			'{{%logs_application}}',
			'application_id',
			'application',
			'id',
			'NO ACTION',
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
