<?php

use yii\db\Migration;

/**
 * Handles the creation for table `push_notification`.
 */
class m160530_113949_create_push_notification extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%push_notification}}', [
            'id'            =>  $this->primaryKey(),
            'device_type'   =>  $this->boolean()->notNull()->comment('1=Android, 2=iOS'),
            'device_token'  =>  $this->string(255)->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci Engine = MyISAM');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%push_notification}}');
    }
}
