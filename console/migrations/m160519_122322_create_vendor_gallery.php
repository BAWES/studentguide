<?php

use yii\db\Migration;

/**
 * Handles the creation for table `vendor_gallery`.
 */
class m160519_122322_create_vendor_gallery extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%vendor_gallery}}', [
            'gallery_id'            =>  $this->primaryKey(),
            'vendor_id'             =>  $this->bigInteger()->notNull(),
            'photo_url'             =>  $this->string(255)->notNull(),
            'photo_added_datetime'  =>  $this->dateTime()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');

        $this->addForeignKey('fk_vg_vendor_id', '{{%vendor_gallery}}', 'vendor_id', '{{%vendor}}', 'vendor_id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%vendor_gallery}}');
    }
}
