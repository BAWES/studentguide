<?php

use yii\db\Migration;

/**
 * Handles the creation for table `vendor`.
 */
class m160519_122018_create_vendor extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%vendor}}', [
            'vendor_id'                 =>  $this->bigPrimaryKey(),
            'vendor_logo'               =>  $this->string(255),
            'vendor_name_en'            =>  $this->string(255)->notNull(),
            'vendor_name_ar'            =>  $this->string(255)->notNull(),
            'vendor_description_en'     =>  $this->text(),
            'vendor_description_ar'     =>  $this->text(),
            'vendor_phone1'             =>  $this->string(15)->notNull(),
            'vendor_phone2'             =>  $this->string(15),
            'vendor_youtube_video'      =>  $this->string(512),
            'vendor_social_instagram'   =>  $this->string(1024),
            'vendor_social_twitter'     =>  $this->string(1024),
            'vendor_location'           =>  $this->string(128),
            'vendor_address_text_en'    =>  $this->string(512),
            'vendor_address_text_ar'    =>  $this->string(512),
            'vendor_account_start_date' =>  $this->date()->notNull(),
            'vendor_account_end_date'   =>  $this->date()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%vendor}}');
    }
}
