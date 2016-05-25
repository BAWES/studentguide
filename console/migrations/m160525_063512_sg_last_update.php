<?php

use yii\db\Migration;

class m160525_063512_sg_last_update extends Migration
{
    public function up()
    {
            $this->createTable('{{%last_update}}', [
            'id'            =>  $this->bigPrimaryKey(),
            'device_token'  =>  $this->string(255)->notNull(),
            'token_type'  =>  $this->string(15)->notNull(),
            'category_key' =>  $this->string(50),
            'vendor_key' =>  $this->string(50),
            'area_key'  =>  $this->string(50),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function down()
    {
        echo "m160525_063512_sg_last_update cannot be reverted.\n";

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
