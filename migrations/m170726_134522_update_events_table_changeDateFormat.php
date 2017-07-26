<?php

use yii\db\Migration;

class m170726_134522_update_events_table_changeDateFormat extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('events', 'date');
        $this->addColumn('events', 'date', 'datetime');
    }

    public function safeDown()
    {
        echo "m170726_134522_update_events_table_changeDateFormat cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170726_134522_update_events_table_changeDateFormat cannot be reverted.\n";

        return false;
    }
    */
}
