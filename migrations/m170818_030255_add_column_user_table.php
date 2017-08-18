<?php

use yii\db\Migration;

class m170818_030255_add_column_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            'user',
            'parent',
            'integer'
        );
        $this->addColumn(
            'user',
            'classManagement',
            'integer'
        );
    }

    public function safeDown()
    {
        echo "m170818_030255_add_column_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170818_030255_add_column_user_table cannot be reverted.\n";

        return false;
    }
    */
}
