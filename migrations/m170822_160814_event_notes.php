<?php

use yii\db\Migration;

class m170822_160814_event_notes extends Migration
{
    public function safeUp()
    {
        $this->createTable('event_notes', [
            'id' => $this->primaryKey(),
            'eventID' => $this->integer(),
            'pupilID' => $this->integer(),
            'note' => $this->text(),
            'worked' => $this->boolean()
        ]);
        $this->createIndex(
            'idx-event_notes-pupilID',
            'event_notes',
            'pupilID'
        );
        $this->createIndex(
            'idx-event_notes-eventID',
            'event_notes',
            'eventID'
        );
    }

    public function safeDown()
    {
        echo "m170822_160814_event_notes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170822_160814_event_notes cannot be reverted.\n";

        return false;
    }
    */
}
