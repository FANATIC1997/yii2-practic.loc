<?php

use yii\db\Migration;

/**
 * Class m220130_111910_init_rbac
 */
class m220130_111910_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    /*public function safeUp()
    {

    }*/

    /**
     * {@inheritdoc}
     */
    /*public function safeDown()
    {
        echo "m220130_111910_init_rbac cannot be reverted.\n";

        return false;
    }*/


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
	    $auth = Yii::$app->authManager;

	    // добавляем роль "user"
	    $user = $auth->createRole('user');
	    $auth->add($user);

	    $manager = $auth->createRole('manager');
	    $auth->add($manager);

	    // добавляем роль "admin"
	    $admin = $auth->createRole('admin');
	    $auth->add($admin);

	    $auth->addChild($admin, $user);
	    $auth->addChild($admin, $manager);
    }

    public function down()
    {
        echo "m220130_111910_init_rbac cannot be reverted.\n";

        return false;
    }

}
