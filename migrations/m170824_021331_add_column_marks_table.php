<?php

use yii\db\Migration;

class m170824_021331_add_column_marks_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            'marks',
            'suprik',
            'integer'
        );
        $this->createIndex(
            'idx-marks-suprik',
            'marks',
            'suprik'
        );
    }

    public function safeDown()
    {
        echo "m170824_021331_add_column_marks_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170824_021331_add_column_marks_table cannot be reverted.\n";

        return false;
    }
    */
}
