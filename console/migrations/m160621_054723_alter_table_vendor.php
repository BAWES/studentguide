<?php

use yii\db\Migration;

class m160621_054723_alter_table_vendor extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%vendor}}', 'vendor_phone1', 'VARCHAR( 15 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL');
    }

    public function down()
    {
        echo "m160621_054723_alter_table_vendor cannot be reverted.\n";

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
