<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "points".
 *
 * @property integer $point
 * @property integer $user_id
 * @property integer $event_id
 */
class Points extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'points';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['point', 'user_id', 'event_id'], 'integer'],
            [['user_id', 'event_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'point' => 'Point',
            'user_id' => 'User ID',
            'event_id' => 'Event ID',
        ];
    }
}
