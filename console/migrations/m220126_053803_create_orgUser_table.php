<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orgUser}}`.
 */
class m220126_053803_create_orgUser_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orgUser}}', [
            'id' => $this->primaryKey(),
			'orgid' => $this->integer()->notNull(),
			'userid' => $this->integer()->notNull()
        ]);

		$this->addForeignKey(
			'org',
			'{{%orgUser}}',
			'orgid',
			'organization',
			'id',
			'CASCADE',
			'CASCADE',
		);

		$this->addForeignKey(
			'user',
			'{{%orgUser}}',
			'userid',
			'user',
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
			'org',
			'{{%orgUser}}'
		);

		$this->dropForeignKey(
			'user',
			'{{%orgUser}}'
		);

        $this->dropTable('{{%orgUser}}');
    }
}
