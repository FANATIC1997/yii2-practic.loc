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

	    $authorRole = $auth->getRole('admin');
	    $auth->assign($authorRole, 1);

	    $authorRole = $auth->getRole('user');
	    $auth->assign($authorRole, 2);

	    $authorRole = $auth->getRole('user');
	    $auth->assign($authorRole, 3);

	    $authorRole = $auth->getRole('user');
	    $auth->assign($authorRole, 4);

	    $authorRole = $auth->getRole('user');
	    $auth->assign($authorRole, 5);

	    $authorRole = $auth->getRole('manager');
	    $auth->assign($authorRole, 6);

	    $authorRole = $auth->getRole('manager');
	    $auth->assign($authorRole, 7);

	    $authorRole = $auth->getRole('manager');
	    $auth->assign($authorRole, 8);

	    $authorRole = $auth->getRole('manager');
	    $auth->assign($authorRole, 9);

	    $authorRole = $auth->getRole('manager');
	    $auth->assign($authorRole, 10);
    }

    public function down()
    {
        echo "m220130_111910_init_rbac cannot be reverted.\n";

        return false;
    }

}
