<?php

use yii\db\Migration;

/**
 * Handles the creation for table `push_notification_history`.
 */
class m160608_135106_create_push_notification_history extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%push_notification_history}}', [
            'id'            =>  $this->primaryKey(),
            'message_en'    =>  $this->string(80)->notNull(),
            'message_ar'    =>  $this->string(80)->notNull(),
            'datetime'      =>  $this->dateTime()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('push_notification_history');
    }
}
