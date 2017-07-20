<?php

use yii\db\Migration;

class m170720_144235_update_table_user_addColumnChild extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            'user',
            'child',
            'integer'
        );
    }

    public function safeDown()
    {
        echo "m170720_144235_update_table_user_addColumnChild cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170720_144235_update_table_user_addColumnChild cannot be reverted.\n";

        return false;
    }
    */
}
