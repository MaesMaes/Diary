<?php

use yii\db\Migration;

/**
 * Handles the creation of table `options`.
 */
class m170729_092008_create_options_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('options', [
            'id' => $this->primaryKey(),
            'prop' => $this->string(),
            'value' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('options');
    }
}
