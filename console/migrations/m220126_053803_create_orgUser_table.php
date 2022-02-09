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

		$this->insert('{{%orgUser}}', ['orgid' => 2, 'userid' => 2]);
		$this->insert('{{%orgUser}}', ['orgid' => 3, 'userid' => 2]);
		$this->insert('{{%orgUser}}', ['orgid' => 4, 'userid' => 2]);


		$this->insert('{{%orgUser}}', ['orgid' => 5, 'userid' => 3]);
		$this->insert('{{%orgUser}}', ['orgid' => 6, 'userid' => 3]);
		$this->insert('{{%orgUser}}', ['orgid' => 7, 'userid' => 3]);


		$this->insert('{{%orgUser}}', ['orgid' => 8, 'userid' => 4]);
		$this->insert('{{%orgUser}}', ['orgid' => 9, 'userid' => 4]);
		$this->insert('{{%orgUser}}', ['orgid' => 10, 'userid' => 4]);


		$this->insert('{{%orgUser}}', ['orgid' => 1, 'userid' => 5]);
		$this->insert('{{%orgUser}}', ['orgid' => 2, 'userid' => 5]);
		$this->insert('{{%orgUser}}', ['orgid' => 3, 'userid' => 5]);


		$this->insert('{{%orgUser}}', ['orgid' => 1, 'userid' => 6]);
		$this->insert('{{%orgUser}}', ['orgid' => 2, 'userid' => 6]);
		$this->insert('{{%orgUser}}', ['orgid' => 3, 'userid' => 6]);


	    $this->insert('{{%orgUser}}', ['orgid' => 4, 'userid' => 7]);
	    $this->insert('{{%orgUser}}', ['orgid' => 5, 'userid' => 7]);
	    $this->insert('{{%orgUser}}', ['orgid' => 6, 'userid' => 7]);

	    $this->insert('{{%orgUser}}', ['orgid' => 7, 'userid' => 8]);
	    $this->insert('{{%orgUser}}', ['orgid' => 8, 'userid' => 8]);
	    $this->insert('{{%orgUser}}', ['orgid' => 9, 'userid' => 8]);


	    $this->insert('{{%orgUser}}', ['orgid' => 1, 'userid' => 9]);
	    $this->insert('{{%orgUser}}', ['orgid' => 2, 'userid' => 9]);
	    $this->insert('{{%orgUser}}', ['orgid' => 3, 'userid' => 9]);
	    $this->insert('{{%orgUser}}', ['orgid' => 7, 'userid' => 9]);
	    $this->insert('{{%orgUser}}', ['orgid' => 10, 'userid' => 9]);

	    $this->insert('{{%orgUser}}', ['orgid' => 4, 'userid' => 10]);
	    $this->insert('{{%orgUser}}', ['orgid' => 5, 'userid' => 10]);
	    $this->insert('{{%orgUser}}', ['orgid' => 6, 'userid' => 10]);
	    $this->insert('{{%orgUser}}', ['orgid' => 10, 'userid' => 10]);
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
