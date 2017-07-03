<?php

use yii\db\Migration;

class m170703_191822_create_table_events extends Migration
{
    public function safeUp()
    {
        $this->createTable('events', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
            'subject'=>$this->integer(),
            'date'=>$this->date(),
            'moderator'=>$this->integer(),
        ]);
    }

    public function safeDown()
    {
        echo "m170703_191822_create_table_events cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170703_191822_create_table_events cannot be reverted.\n";

        return false;
    }
    */
}
