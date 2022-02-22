<?php

use yii\db\Migration;

/**
 * Class m220222_061403_update_application_table
 */
class m220222_061403_update_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->addColumn('application', 'rating', $this->integer()->null());
		$this->addColumn('application', 'review', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220222_061403_update_application_table cannot be reverted.\n";

		$this->dropColumn('application', 'rating');
		$this->dropColumn('application', 'review');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220222_061403_update_application_table cannot be reverted.\n";

        return false;
    }
    */
}
