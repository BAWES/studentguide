<?php

use yii\db\Migration;

class m160527_054259_sg_enquiry extends Migration
{
    public function up()
    {
        $this->createTable('{{%enquiry}}',[
            'enquiry_id' => $this->bigPrimaryKey(),
            'name'       => $this->string(255),
            'message'   => $this->text(),
            'mobile'    => $this->string(15),
            'created_datetime'  =>  $this->dateTime(),
            'modified_datetime' =>  $this->dateTime(),
            ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
    }

    public function down()
    {
        echo "m160527_054259_sg_enquiry cannot be reverted.\n";

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
