<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "events_users".
 *
 * @property integer $event_id
 * @property integer $user_id
 */
class EventsUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'user_id'], 'required'],
            [['event_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'Event ID',
            'user_id' => 'User ID',
        ];
    }


}
