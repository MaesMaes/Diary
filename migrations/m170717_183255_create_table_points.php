<?php

use yii\db\Migration;

class m170717_183255_create_table_points extends Migration
{
    public function safeUp()
    {
        $this->createTable('points', [
            'point' => $this->integer(),
            'user_id' => $this->integer(),
            'event_id' => $this->integer(),
            'PRIMARY KEY(event_id, user_id)',
        ]);

        $this->createIndex(
            'idx-points-event_id',
            'points',
            'event_id'
        );
        $this->createIndex(
            'idx-points-user_id',
            'points',
            'user_id'
        );
    }

    public function safeDown()
    {
        echo "m170717_183255_create_table_points cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170717_183255_create_table_points cannot be reverted.\n";

        return false;
    }
    */
}
