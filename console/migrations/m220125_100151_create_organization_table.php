<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%organization}}`.
 */
class m220125_100151_create_organization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%organization}}', [
            'id' => $this->primaryKey(),
			'name' => $this->string()->notNull()->unique(),
			'address' => $this->string()->notNull(),
			'contact' => $this->string()->notNull(),
        ]);


	    $this->insert('{{%organization}}', [
	    	'id' => 1,
	    	'name' => 'ООО "Роутим"',
		    'address' => 'Ставрополь, ул. Доваторцева 11а',
		    'contact' => '+7 938 309 4124'
	    ]);

	    $this->insert('{{%organization}}', [
		    'id' => 2,
		    'name' => 'Яндекс',
		    'address' => 'Москва',
		    'contact' => '+7 465 139 1668'
	    ]);

	    $this->insert('{{%organization}}', [
		    'id' => 3,
		    'name' => 'Каприз',
		    'address' => 'Красноярск',
		    'contact' => '+7 983 291 3254'
	    ]);

	    $this->insert('{{%organization}}', [
		    'id' => 4,
		    'name' => 'Конверсайт',
		    'address' => 'Красноярск',
		    'contact' => '+7 988 422 2464'
	    ]);

	    $this->insert('{{%organization}}', [
		    'id' => 5,
		    'name' => 'ООО «АГРИСТО»',
		    'address' => '355040, г. Ставрополь, ул. Доваторцев, 39 А, agroteh2@yandex.ru',
		    'contact' => '95-64-67'
	    ]);

	    $this->insert('{{%organization}}', [
		    'id' => 6,
		    'name' => 'ЗАО «Биоком»',
		    'address' => '355016, г.Ставрополь, Чапаевский проезд, 54 biocom@biocom.ru',
		    'contact' => '95-57-45'
	    ]);

	    $this->insert('{{%organization}}', [
		    'id' => 7,
		    'name' => 'ФКП «Ставропольская Биофабрика»',
		    'address' => '355019, г. Ставрополь, ул. Биологическая, 18 info@stavbio.ru',
		    'contact' => '28-76-42'
	    ]);

	    $this->insert('{{%organization}}', [
		    'id' => 8,
		    'name' => 'ОАО «Торговый дом «Иней»',
		    'address' => '355035, г. Ставрополь, Старомарьевское шоссе, 13',
		    'contact' => '28-03-93'
	    ]);

	    $this->insert('{{%organization}}', [
		    'id' => 9,
		    'name' => 'ЗАО «Мирком»',
		    'address' => '355035, г. Ставрополь, Старомарьевское шоссе, 8 mirkom@mail.ru',
		    'contact' => '27-10-00'
	    ]);

	    $this->insert('{{%organization}}', [
		    'id' => 10,
		    'name' => 'АО «Молочный комбинат Ставропольский»',
		    'address' => '355037, г. Ставрополь, ул. Доваторцев, 36 mokostav@mail.ru',
		    'contact' => '24-70-95'
	    ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%organization}}');
    }
}
