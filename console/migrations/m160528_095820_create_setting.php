<?php

use yii\db\Migration;

/**
 * Handles the creation for table `setting`.
 */
class m160528_095820_create_setting extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%setting}}', [
            'id'                    =>  $this->primaryKey(),
            'terms_and_conditions'  =>  $this->text()->notNull(),
            'contact_email'         =>  $this->string(255)->notNull()
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%setting}}');
    }
}
