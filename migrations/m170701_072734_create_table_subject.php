<?php

use yii\db\Migration;

class m170701_072734_create_table_subject extends Migration
{
    public function safeUp()
    {
        $this->createTable('subject', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
        ]);
    }

    public function safeDown()
    {
        echo "m170701_072734_create_table_subject cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170701_072734_create_table_subject cannot be reverted.\n";

        return false;
    }
    */
}
