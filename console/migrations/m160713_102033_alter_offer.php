<?php

use yii\db\Migration;

class m160713_102033_alter_offer extends Migration
{
    public function up()
    {
        $this->addColumn('{{%offers}}', 'status', 'TINYINT(1) NOT NULL COMMENT "1=Active, 0=Deactive" AFTER end_date');
        $this->addColumn('{{%offers}}', 'created_datetime', 'DATETIME NOT NULL AFTER status');
        $this->addColumn('{{%offers}}', 'modified_datetime', 'DATETIME NOT NULL AFTER created_datetime');
    }

    public function down()
    {
        echo "m160713_102033_alter_offer cannot be reverted.\n";

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
