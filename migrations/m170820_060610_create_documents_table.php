<?php

use yii\db\Migration;

/**
 * Handles the creation of table `documents`.
 */
class m170820_060610_create_documents_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('documents', [
            'id' => $this->primaryKey(),
            'category' => $this->integer(),
            'path' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('documents');
    }
}
