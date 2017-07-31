<?php

use yii\db\Migration;

class m170730_153845_create_table_banners extends Migration
{
    public function safeUp()
    {
        $this->createTable('banners', [
            'id' => $this->primaryKey(),
            'URLs' => $this->string(),
            'roleIDs' => $this->string()
        ]);
    }

    public function safeDown()
    {
        echo "m170730_153845_create_table_banners cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170730_153845_create_table_banners cannot be reverted.\n";

        return false;
    }
    */
}
