<?php

use yii\db\Migration;

class m170814_023822_update_events_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            'events',
            'duration',
            'integer'
        );
    }

    public function safeDown()
    {
        echo "m170814_023822_update_events_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170814_023822_update_events_table cannot be reverted.\n";

        return false;
    }
    */
}
