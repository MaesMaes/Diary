<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event_notes".
 *
 * @property integer $id
 * @property integer $eventID
 * @property integer $pupilID
 * @property string $note
 * @property integer $worked
 */
class EventNotes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_notes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['eventID', 'pupilID', 'worked'], 'integer'],
            [['note'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eventID' => 'Event ID',
            'pupilID' => 'Pupil ID',
            'note' => 'Note',
            'worked' => 'Worked',
        ];
    }
}
