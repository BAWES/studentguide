<?php

use yii\db\Migration;

/**
 * Handles the creation for table `offers`.
 */
class m160713_093426_create_offers extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%offers}}', [
            'id'            =>  $this->bigPrimaryKey(),
            'name'          =>  $this->string(255)->notNull(),
            'url'           =>  $this->text()->notNull(),
            'image'         =>  $this->string(255)->notNull(),
            'start_date'    =>  $this->date()->notNull(),
            'end_date'      =>  $this->date()->notNull(),
        ], 'CHARACTER SET = utf8, COLLATE = utf8_general_ci');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%offers}}');
    }
}
