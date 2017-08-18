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
            [['date'], 'default', 'value' => date('Y-m-d H:i:s')],
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
            'costsID' => 'ИД расхода',
            'date' => 'Дата',
            'itemOfExpenditure' => 'Статья расхода',
            'name' => 'ФИО получившего',
            'sum' => 'Сумма',
            'description' => 'Примечание',
        ];
    }

    public static function getAllItemOfExpenditure()
    {
        return [
            0 => 'Статья 1',
            1 => 'Статья 2',
            2 => 'Статья 3',
            3 => 'Статья 4',
        ];
    }
}
