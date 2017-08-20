<?php

use yii\db\Migration;

class m170820_061648_add_column_documents_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            'documents',
            'name',
            'string'
        );
    }

    public function safeDown()
    {
        echo "m170820_061648_add_column_documents_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170820_061648_add_column_documents_table cannot be reverted.\n";

        return false;
    }
    */
}
