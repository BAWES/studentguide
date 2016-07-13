<?php

use yii\db\Migration;

class m160713_123602_alter_offer extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%offers}}', 'name', 'name_en');
        $this->addColumn('{{%offers}}', 'name_ar', 'varchar(255) NOT NULL AFTER name_en');
    }

    public function down()
    {
        echo "m160713_123602_alter_offer cannot be reverted.\n";

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
