<?php

use yii\db\Migration;

class m170704_084857_create_table_events_users extends Migration
{
    public function safeUp()
    {
        $this->createTable('events_users', [
            'event_id' => $this->integer(),
            'user_id' => $this->integer(),
            'PRIMARY KEY(event_id, user_id)',
        ]);

        $this->createIndex(
            'idx-events_users-event_id',
            'events_users',
            'event_id'
        );

        $this->createIndex(
            'idx-events_users-user_id',
            'events_users',
            'user_id'
        );
    }

    public function safeDown()
    {
        echo "m170704_084857_create_table_events_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170704_084857_create_table_events_users cannot be reverted.\n";

        return false;
    }
    */
}
