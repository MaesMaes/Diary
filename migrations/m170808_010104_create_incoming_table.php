<?php

use yii\db\Migration;

/**
 * Handles the creation of table `incoming`.
 */
class m170808_010104_create_incoming_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('incoming', [
            'incomingID' => $this->primaryKey(),
            'childName' => $this->integer(),
            'subject' => $this->integer(),
            'sum' => $this->integer(),
            'description' => $this->string(),
            'parentName' => $this->string(),
            'checkingAccount' => $this->boolean(),
        ]);

        $this->createIndex(
            'idx-incoming-checkingAccount',
            'incoming',
            'checkingAccount'
        );
        $this->createIndex(
            'idx-incoming-sum',
            'incoming',
            'sum'
        );
        $this->createIndex(
            'idx-incoming-subject',
            'incoming',
            'subject'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('incoming');
    }
}
