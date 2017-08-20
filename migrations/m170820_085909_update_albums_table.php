<?php

use yii\db\Migration;

class m170820_085909_update_albums_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn(
            'albums',
            'images'
        );
        $this->addColumn(
            'albums',
            'images',
            'text'
        );
    }

    public function safeDown()
    {
        echo "m170820_085909_update_albums_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170820_085909_update_albums_table cannot be reverted.\n";

        return false;
    }
    */
}
