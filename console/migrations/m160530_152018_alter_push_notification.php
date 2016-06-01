<?php

use yii\db\Migration;

class m160530_152018_alter_push_notification extends Migration
{
    public function up()
    {
        $this->addColumn("{{%push_notification}}", "language", $this->string(5)->defaultValue("en"));
    }

    public function down()
    {
        echo "m160530_152018_alter_push_notification cannot be reverted.\n";

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
