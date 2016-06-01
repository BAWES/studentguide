<?php

use yii\db\Migration;

class m160530_102244_alter_last_update extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%last_update}}', 'device_token');
        $this->dropColumn('{{%last_update}}', 'token_type');
    }

    public function down()
    {
        echo "m160530_102244_alter_last_update cannot be reverted.\n";

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
