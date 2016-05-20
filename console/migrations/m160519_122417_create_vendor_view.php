<?php

use yii\db\Migration;

/**
 * Handles the creation for table `vendor_view`.
 */
class m160519_122417_create_vendor_view extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%vendor_view}}', [
            'view_id'           =>  $this->bigPrimaryKey(),
            'vendor_id'         =>  $this->bigInteger()->notNull(),
            'view_date'         =>  $this->date()->notNull(),
            'number_of_views'   =>  $this->integer()->notNull()->defaultValue(0),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');

        $this->addForeignKey('fk_vv_vendor_id', '{{%vendor_view}}', 'vendor_id', '{{%vendor}}', 'vendor_id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%vendor_view}}');
    }
}
