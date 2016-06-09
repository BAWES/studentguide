<?php

use yii\db\Migration;

class m160603_100337_alter_vendor extends Migration
{
    public function up()
    {
        $this->addColumn('{{%vendor}}', 'sort_order', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        echo "m160603_100337_alter_vendor cannot be reverted.\n";

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
