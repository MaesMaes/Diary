<?php

use yii\db\Migration;

/**
 * Handles the creation of table `albums`.
 */
class m170820_074507_create_albums_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('albums', [
            'id' => $this->primaryKey(),
            'creatorID' => $this->integer(),
            'name' => $this->string(),
            'images' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('albums');
    }
}
