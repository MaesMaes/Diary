<?php

use yii\db\Migration;

class m170625_124417_update_table_users extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'lastName', 'string(50)');
        $this->addColumn('user', 'phone', 'string(50)');
        $this->addColumn('user', 'birthDate', 'date');
    }

    public function safeDown()
    {
        echo "m170625_124417_update_table_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170625_124417_update_table_users cannot be reverted.\n";

        return false;
    }
    */
}
