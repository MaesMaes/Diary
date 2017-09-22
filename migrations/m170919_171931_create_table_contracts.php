<?php

use yii\db\Migration;

class m170919_171931_create_table_contracts extends Migration
{
    public function safeUp()
    {
        $this->createTable('contracts', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'child_id' => $this->integer()->notNull(),
            'datetime' => $this->dateTime(),
            'note' => $this->text(),
            'is_stopped' => $this->boolean()->defaultValue(false),
        ]);

        $this->createTable('contract_types', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'price' => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('contracts');
        $this->dropTable('contract_types');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170919_171931_create_table_contracts cannot be reverted.\n";

        return false;
    }
    */
}
