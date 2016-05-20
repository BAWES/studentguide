<?php

use yii\db\Migration;

/**
 * Handles the creation for table `category`.
 */
class m160519_114430_create_category extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%category}}', [
            'category_id'                           =>  $this->bigPrimaryKey(),
            'parent_category_id'                    =>  $this->bigInteger(),
            'category_name_en'                      =>  $this->string(255)->notNull(),
            'category_name_ar'                      =>  $this->string(255)->notNull(),
            'category_vendors_filterable_by_area'   =>  $this->boolean()->defaultValue(false),
            'category_created_datetime'             =>  $this->dateTime(),
            'category_updated_datetime'             =>  $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');

        $this->addForeignKey('fk_cat_id', '{{%category}}', 'parent_category_id', '{{%category}}', 'category_id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%category}}');
    }
}
