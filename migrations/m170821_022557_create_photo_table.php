<?php

use yii\db\Migration;

/**
 * Handles the creation of table `photo`.
 */
class m170821_022557_create_photo_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('photo', [
            'id' => $this->primaryKey(),
            'albumID' => $this->integer(),
            'url' => $this->string(),
            'active' => $this->boolean()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('photo');
    }
}
