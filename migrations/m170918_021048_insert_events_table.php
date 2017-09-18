<?php

use yii\db\Migration;

class m170918_021048_insert_events_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            'events',
            'event_title',
            'string'
        );
    }

    public function safeDown()
    {
        echo "m170918_021048_insert_events_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170918_021048_insert_events_table cannot be reverted.\n";

        return false;
    }
    */
}
