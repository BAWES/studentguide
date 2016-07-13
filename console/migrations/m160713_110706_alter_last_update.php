<?php

use yii\db\Migration;

class m160713_110706_alter_last_update extends Migration
{
    public function up()
    {
        $this->addColumn('{{%last_update}}', 'offer_key', 'string(16) NOT NULL AFTER area_key');
        $this->update('{{%last_update}}', ['offer_key' => "AbsuwXuswq"]);
    }

    public function down()
    {
        echo "m160713_110706_alter_last_update cannot be reverted.\n";

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
