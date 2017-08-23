<?php

use yii\db\Migration;

class m170823_134627_update_event_notes_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn(
            'event_notes',
            'eventID'
        );
        $this->addColumn(
            'event_notes',
            'date',
            'datetime'
        );
    }

    public function safeDown()
    {
        echo "m170823_134627_update_event_notes_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170823_134627_update_event_notes_table cannot be reverted.\n";

        return false;
    }
    */
}
