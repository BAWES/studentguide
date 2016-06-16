<?php

use yii\db\Migration;

class m160616_114916_alter_table_vendor extends Migration
{
    public function up()
    {
        $this->addColumn('{{%vendor}}', 'vendor_website',  'VARCHAR(256) AFTER vendor_phone2');
    }

    public function down()
    {
        echo "m160616_114916_alter_table_vendor cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
