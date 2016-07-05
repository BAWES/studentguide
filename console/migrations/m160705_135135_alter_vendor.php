<?php

use yii\db\Migration;

class m160705_135135_alter_vendor extends Migration
{
    public function up()
    {
        $this->addColumn('{{%vendor}}', 'vendor_governorate', 'VARCHAR(125) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER vendor_location');
    }

    public function down()
    {
        echo "m160705_135135_alter_vendor cannot be reverted.\n";

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
