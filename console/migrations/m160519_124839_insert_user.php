<?php

use yii\db\Migration;

class m160519_124839_insert_user extends Migration
{
    public function up()
    {
        $this->insert('{{%user}}', [
            'username'              =>  'Admin',
            'auth_key'              =>  'ssss',
            'password_hash'         =>  '$2y$13$a1CtIHXBJ9grdb6409uRvud3KBaeCRYfqIGC6Hn2LT9cxdRpu/rzm',
            'email'                 =>  'sivabalan.s@technoduce.com',
            'status'                =>  '10',
            'created_at'            =>  '0',
            'updated_at'            =>  '0',
        ]);
    }

    public function down()
    {
        echo "m160519_124839_insert_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
