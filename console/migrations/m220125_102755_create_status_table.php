<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status}}`.
 */
class m220125_102755_create_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%status}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

		$this->insert('{{%status}}', ['name' => 'Новая']);
		$this->insert('{{%status}}', ['name' => 'В работе']);
		$this->insert('{{%status}}', ['name' => 'Готово']);
		$this->insert('{{%status}}', ['name' => 'Закрыто']);
		$this->insert('{{%status}}', ['name' => 'Доработка']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%status}}');
    }
}
