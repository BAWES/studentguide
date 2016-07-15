<?php

use yii\db\Migration;

class m160714_120037_alter_offer extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%offers}}', 'url', 'text null');
    }

    public function down()
    {
        echo "m160714_120037_alter_offer cannot be reverted.\n";

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
