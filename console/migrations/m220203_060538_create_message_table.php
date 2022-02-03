<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 */
class m220203_060538_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'application_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'message' => $this->string(),
        ]);

		$this->addForeignKey(
			'ap_ms',
			'{{%message}}',
			'application_id',
			'application',
			'id',
			'CASCADE',
			'CASCADE',
		);

		$this->addForeignKey(
			'us_ms',
			'{{%message}}',
			'user_id',
			'user',
			'id',
			'NO ACTION',
			'CASCADE',
		);

		$this->addForeignKey(
			'st_ms',
			'{{%message}}',
			'status_id',
			'status',
			'id',
			'CASCADE',
			'CASCADE',
		);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$this->dropForeignKey(
			'ap_ms',
			'{{%message}}'
		);

		$this->dropForeignKey(
			'us_ms',
			'{{%message}}'
		);

		$this->dropForeignKey(
			'st_ms',
			'{{%message}}'
		);


        $this->dropTable('{{%message}}');
    }
}
