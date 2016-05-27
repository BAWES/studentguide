<?php

use yii\db\Migration;

class m160527_113229_increasekey_length extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%last_update}}','category_key',$this->string(255));
        $this->alterColumn('{{%last_update}}','vendor_key',$this->string(255));
        $this->alterColumn('{{%last_update}}','area_key',$this->string(255));
    }

    public function down()
    {
        echo "m160527_113229_increasekey_length cannot be reverted.\n";

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
