<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "costs".
 *
 * @property integer $costsID
 * @property string $date
 * @property integer $itemOfExpenditure
 * @property integer $name
 * @property integer $sum
 * @property string $description
 */
class Costs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'costs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['itemOfExpenditure', 'name', 'sum'], 'integer'],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'costsID' => 'Costs ID',
            'date' => 'Date',
            'itemOfExpenditure' => 'Item Of Expenditure',
            'name' => 'Name',
            'sum' => 'Sum',
            'description' => 'Description',
        ];
    }
}
