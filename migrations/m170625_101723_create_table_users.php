<?php

use yii\db\Migration;

class m170625_101723_create_table_users extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
            'email'=>$this->string()->defaultValue(null),
            'password'=>$this->string(),
            'isAdmin'=>$this->integer()->defaultValue(0),
            'photo'=>$this->string()->defaultValue(null)
        ]);
    }

    public function safeDown()
    {
        echo "m170625_101723_create_table_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170625_101723_create_table_users cannot be reverted.\n";

        return false;
    }
    */
}
