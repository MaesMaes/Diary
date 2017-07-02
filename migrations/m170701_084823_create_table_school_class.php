<?php

use yii\db\Migration;

class m170701_084823_create_table_school_class extends Migration
{
    public function safeUp()
    {
        $this->createTable('school_class', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
        ]);
    }

    public function safeDown()
    {
        echo "m170701_084823_create_table_school_class cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170701_084823_create_table_school_class cannot be reverted.\n";

        return false;
    }
    */
}
