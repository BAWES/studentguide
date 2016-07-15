<?php

use yii\db\Migration;

class m160714_061452_alter_vendor extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%vendor}}', 'vendor_governorate', 'vendor_area_name_en');
        $this->addColumn('{{%vendor}}', 'vendor_area_name_ar', 'VARCHAR(125) AFTER vendor_area_name_en');
    }

    public function down()
    {
        echo "m160714_061452_alter_vendor cannot be reverted.\n";

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
