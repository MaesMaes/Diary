<?php

use yii\db\Migration;

class m170808_024151_update_tables_costs_incoming_date extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('costs', 'date');
        $this->addColumn('costs', 'date', 'datetime');

        $this->addColumn('incoming', 'date', 'datetime');
    }

    public function safeDown()
    {
        echo "m170808_024151_update_tables_costs_incoming_date cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170808_024151_update_tables_costs_incoming_date cannot be reverted.\n";

        return false;
    }
    */
}
