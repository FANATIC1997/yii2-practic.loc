<?php

use yii\db\Expression;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'phone' => $this->bigInteger()->notNull(),
            'auth_key' => $this->string(32)->null(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions);



        $this->insert('{{%user}}', [
        	'id' => 1,
	        'username' => 'Admin',
	        'phone' => '9881059955',
	        'password_hash' => '$2y$13$w0bY7cyoAwJXi7zrMqYPGu4dVejXRxQy7Glhd3.v7wVR0dlUYSkjm',
	        'email' => 'shram-mamb@mail.ru',
	        'status' => 10,
	        'created_at' => new Expression('NOW()'),
	        'updated_at' => new Expression('NOW()')
        ]);

	    $this->insert('{{%user}}', [
		    'id' => 2,
		    'username' => 'FANATIC',
		    'phone' => '9881059955',
		    'password_hash' => '$2y$13$w0bY7cyoAwJXi7zrMqYPGu4dVejXRxQy7Glhd3.v7wVR0dlUYSkjm',
		    'email' => 'shram-mamb2016@mail.ru',
		    'status' => 10,
		    'created_at' => new Expression('NOW()'),
		    'updated_at' => new Expression('NOW()')
	    ]);

	    $this->insert('{{%user}}', [
		    'id' => 3,
		    'username' => 'Lilop',
		    'phone' => '9881059955',
		    'password_hash' => '$2y$13$w0bY7cyoAwJXi7zrMqYPGu4dVejXRxQy7Glhd3.v7wVR0dlUYSkjm',
		    'email' => 'shram-mamb20161@mail.ru',
		    'status' => 10,
		    'created_at' => new Expression('NOW()'),
		    'updated_at' => new Expression('NOW()')
	    ]);

	    $this->insert('{{%user}}', [
		    'id' => 4,
		    'username' => 'User',
		    'phone' => '9881059955',
		    'password_hash' => '$2y$13$w0bY7cyoAwJXi7zrMqYPGu4dVejXRxQy7Glhd3.v7wVR0dlUYSkjm',
		    'email' => 'shram-mamb201621@mail.ru',
		    'status' => 10,
		    'created_at' => new Expression('NOW()'),
		    'updated_at' => new Expression('NOW()')
	    ]);

	    $this->insert('{{%user}}', [
		    'id' => 5,
		    'username' => 'Joink',
		    'phone' => '9881059955',
		    'password_hash' => '$2y$13$w0bY7cyoAwJXi7zrMqYPGu4dVejXRxQy7Glhd3.v7wVR0dlUYSkjm',
		    'email' => 'shram-mamb201@mail.ru',
		    'status' => 10,
		    'created_at' => new Expression('NOW()'),
		    'updated_at' => new Expression('NOW()')
	    ]);

	    $this->insert('{{%user}}', [
		    'id' => 6,
		    'username' => 'Kilom',
		    'phone' => '9881059955',
		    'password_hash' => '$2y$13$w0bY7cyoAwJXi7zrMqYPGu4dVejXRxQy7Glhd3.v7wVR0dlUYSkjm',
		    'email' => 'shram-mamb2@mail.ru',
		    'status' => 10,
		    'created_at' => new Expression('NOW()'),
		    'updated_at' => new Expression('NOW()')
	    ]);

	    $this->insert('{{%user}}', [
		    'id' => 7,
		    'username' => 'Malik',
		    'phone' => '9881059955',
		    'password_hash' => '$2y$13$w0bY7cyoAwJXi7zrMqYPGu4dVejXRxQy7Glhd3.v7wVR0dlUYSkjm',
		    'email' => 'shram-mamb2@gmail.com',
		    'status' => 10,
		    'created_at' => new Expression('NOW()'),
		    'updated_at' => new Expression('NOW()')
	    ]);

	    $this->insert('{{%user}}', [
		    'id' => 8,
		    'username' => 'Unndo',
		    'phone' => '9881059955',
		    'password_hash' => '$2y$13$w0bY7cyoAwJXi7zrMqYPGu4dVejXRxQy7Glhd3.v7wVR0dlUYSkjm',
		    'email' => 'shram-mamb2016@gmail.com',
		    'status' => 10,
		    'created_at' => new Expression('NOW()'),
		    'updated_at' => new Expression('NOW()')
	    ]);

	    $this->insert('{{%user}}', [
		    'id' => 9,
		    'username' => 'Shakil',
		    'phone' => '9881059955',
		    'password_hash' => '$2y$13$w0bY7cyoAwJXi7zrMqYPGu4dVejXRxQy7Glhd3.v7wVR0dlUYSkjm',
		    'email' => 'shrammamb1997@gmail.com',
		    'status' => 10,
		    'created_at' => new Expression('NOW()'),
		    'updated_at' => new Expression('NOW()')
	    ]);

	    $this->insert('{{%user}}', [
		    'id' => 10,
		    'username' => 'Chomor',
		    'phone' => '9881059955',
		    'password_hash' => '$2y$13$w0bY7cyoAwJXi7zrMqYPGu4dVejXRxQy7Glhd3.v7wVR0dlUYSkjm',
		    'email' => 'shrammamb19971@gmail.com',
		    'status' => 10,
		    'created_at' => new Expression('NOW()'),
		    'updated_at' => new Expression('NOW()')
	    ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
