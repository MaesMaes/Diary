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
            'incomingID' => 'Incoming ID',
            'childName' => 'Child Name',
            'subject' => 'Subject',
            'sum' => 'Sum',
            'description' => 'Description',
            'parentName' => 'Parent Name',
            'checkingAccount' => 'Checking Account',
        ];
    }
}
