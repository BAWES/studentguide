<?php

use yii\db\Migration;

class m160801_105401_alter_settings extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%setting}}', 'offer_image_min_size', 'offer_image_height');
        $this->renameColumn('{{%setting}}', 'offer_image_max_size', 'offer_image_width');
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
