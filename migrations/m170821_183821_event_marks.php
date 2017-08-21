<?php

use yii\db\Migration;

class m170821_183821_event_marks extends Migration
{
    public function safeUp()
    {
        $this->createTable('marks', [
            'id' => $this->primaryKey(),
            'eventID' => $this->integer(),
            'pupilID' => $this->string(),
            'test' => $this->integer(),
            'test_theme' => $this->integer(),
            'test_lesson' => $this->integer(),
            'lights' => $this->integer(),
            'active' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-marks-eventID',
            'marks',
            'eventID'
        );
        $this->createIndex(
            'idx-marks-pupilID',
            'marks',
            'pupilID'
        );
    }

    public function safeDown()
    {
        echo "m170821_183821_event_marks cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170821_183821_event_marks cannot be reverted.\n";

        return false;
    }
    */
}
