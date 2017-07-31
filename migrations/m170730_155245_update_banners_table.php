<?php

use yii\db\Migration;

class m170730_155245_update_banners_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            'banners',
            'place',
            'integer'
        );
    }

    public function safeDown()
    {
        echo "m170730_155245_update_banners_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170730_155245_update_banners_table cannot be reverted.\n";

        return false;
    }
    */
}
