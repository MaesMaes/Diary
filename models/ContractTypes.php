<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contract_types".
 *
 * @property integer $id
 * @property string $title
 * @property integer $price
 */
class ContractTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contract_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'price'], 'required'],
            [['price'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Цена',
            'title' => 'Название контракта'
        ];
    }
}
