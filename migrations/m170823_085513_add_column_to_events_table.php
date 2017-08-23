<?php

use yii\db\Migration;

class m170823_085513_add_column_to_events_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            'events',
            'theme',
            'string'
        );
        $this->addColumn(
            'events',
            'standard',
            'string'
        );
        $this->addColumn(
            'events',
            'deep',
            'string'
        );
    }

    public function safeDown()
    {
        echo "m170823_085513_add_column_to_events_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170823_085513_add_column_to_events_table cannot be reverted.\n";

        return false;
    }
    */
}
