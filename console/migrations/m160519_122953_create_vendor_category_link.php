<?php

use yii\db\Migration;

/**
 * Handles the creation for table `vendor_category_link`.
 */
class m160519_122953_create_vendor_category_link extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%vendor_category_link}}', [
            'link_id'           =>  $this->bigPrimaryKey(),
            'vendor_id'         =>  $this->bigInteger()->notNull(),
            'category_id'       =>  $this->bigInteger()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');

        $this->addForeignKey('fk_vc_vendor_id', '{{%vendor_category_link}}', 'vendor_id', '{{%vendor}}', 'vendor_id', 'CASCADE');
        $this->addForeignKey('fk_vc_category_id', '{{%vendor_category_link}}', 'category_id', '{{%category}}', 'category_id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%vendor_category_link}}');
    }
}
