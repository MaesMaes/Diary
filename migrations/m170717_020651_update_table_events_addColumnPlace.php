<?php

use yii\db\Migration;

class m170717_020651_update_table_events_addColumnPlace extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            'events',
            'place',
            'string'
        );
    }

    public function safeDown()
    {
        echo "m170717_020651_update_table_events_addColumnPlace cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170717_020651_update_table_events_addColumnPlace cannot be reverted.\n";

        return false;
    }
    */
}
