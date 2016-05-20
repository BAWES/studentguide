<?php

use yii\db\Migration;

/**
 * Handles the creation for table `vendor_area_link`.
 */
class m160519_122523_create_vendor_area_link extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%vendor_area_link}}', [
            'link_id'           =>  $this->bigPrimaryKey(),
            'vendor_id'         =>  $this->bigInteger()->notNull(),
            'area_id'           =>  $this->integer()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');

        $this->addForeignKey('fk_va_vendor_id', '{{%vendor_area_link}}', 'vendor_id', '{{%vendor}}', 'vendor_id', 'CASCADE');
        $this->addForeignKey('fk_va_area_id', '{{%vendor_area_link}}', 'area_id', '{{%area}}', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%vendor_area_link}}');
    }
}
