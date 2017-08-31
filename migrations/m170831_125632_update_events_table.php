<?php

use yii\db\Migration;

class m170831_125632_update_events_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            'events',
            'task1',
            'string'
        );
        $this->addColumn(
            'events',
            'task2',
            'string'
        );
        $this->addColumn(
            'events',
            'spend',
            'boolean'
        );
    }

    public function safeDown()
    {
        echo "m170831_125632_update_events_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170831_125632_update_events_table cannot be reverted.\n";

        return false;
    }
    */
}
