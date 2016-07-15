<?php

use yii\db\Migration;

class m160714_063522_alter_offers extends Migration
{
    public function up()
    {
        $this->addColumn('{{%offers}}', 'sort_order', $this->integer()->defaultValue(0)->after('status'));
    }

    public function down()
    {
        echo "m160714_063522_alter_offers cannot be reverted.\n";

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
