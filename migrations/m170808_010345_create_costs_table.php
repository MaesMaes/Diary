<?php

use yii\db\Migration;

/**
 * Handles the creation of table `costs`.
 */
class m170808_010345_create_costs_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('costs', [
            'costsID' => $this->primaryKey(),
            'date' => $this->date(),
            'itemOfExpenditure' => $this->integer(),
            'name' => $this->integer(),
            'sum' => $this->integer(),
            'description' => $this->string(),
        ]);

        $this->createIndex(
            'idx-costs-date',
            'costs',
            'date'
        );
        $this->createIndex(
            'idx-costs-itemOfExpenditure',
            'costs',
            'itemOfExpenditure'
        );
        $this->createIndex(
            'idx-costs-name',
            'costs',
            'name'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('costs');
    }
}
