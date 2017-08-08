<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "incoming".
 *
 * @property integer $incomingID
 * @property integer $childName
 * @property integer $subject
 * @property integer $sum
 * @property string $description
 * @property string $parentName
 * @property integer $checkingAccount
 * @property string $date
 */
class Incoming extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'incoming';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['childName', 'subject', 'sum', 'checkingAccount'], 'integer'],
            [['description', 'parentName'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'incomingID' => 'ID прихода',
            'childName' => 'Имя ребенка',
            'subject' => 'За что',
            'sum' => 'Сумма',
            'description' => 'Примечание',
            'parentName' => 'Родитель',
            'checkingAccount' => 'Тип платежа',
            'date' => 'Дата',
        ];
    }

    public static function getAllSubjects()
    {
        return [
            0 => 'Пункт 1',
            1 => 'Пункт 2',
            2 => 'Пункт 3',
            3 => 'Пункт 4',
        ];
    }


}
