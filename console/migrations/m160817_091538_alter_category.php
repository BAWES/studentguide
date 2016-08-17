<?php

use yii\db\Migration;

class m160817_091538_alter_category extends Migration
{
    public function up()
    {
        $this->addColumn('{{%category}}', 'status', 'tinyint(1) DEFAULT 1 AFTER category_vendors_filterable_by_area');
    }

    public function down()
    {
        echo "m160817_091538_alter_category cannot be reverted.\n";

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
