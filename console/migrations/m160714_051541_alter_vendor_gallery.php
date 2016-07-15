<?php

use yii\db\Migration;

class m160714_051541_alter_vendor_gallery extends Migration
{
    public function up()
    {
        $this->addColumn('{{%vendor_gallery}}', 'sort_order', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        echo "m160714_051541_alter_vendor_gallery cannot be reverted.\n";

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
