<?php

use yii\db\Migration;

/**
 * Handles the creation for table `area`.
 */
class m160519_114053_create_area extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%area}}', [
            'id'            =>  $this->primaryKey(),
            'area_name_en'  =>  $this->string(255)->notNull(),
            'area_name_ar'  =>  $this->string(255)->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%area}}');
    }
}
