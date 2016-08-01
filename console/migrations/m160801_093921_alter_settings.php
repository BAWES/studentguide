<?php

use yii\db\Migration;

class m160801_093921_alter_settings extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%setting}}', 'offer_image_min_size', $this->integer()->notNull()->defaultValue(100));
    	$this->addColumn('{{%setting}}', 'offer_image_max_size', $this->integer()->notNull()->defaultValue(100));
    }

    public function down()
    {
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
