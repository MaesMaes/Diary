<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event_notes".
 *
 * @property integer $id
 * @property integer $pupilID
 * @property string $note
 * @property integer $worked
 * @property string $date
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
            [['pupilID', 'worked'], 'integer'],
            [['note'], 'string'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pupilID' => 'Ученик',
            'note' => 'Замечание',
            'worked' => 'Отработано',
            'date' => 'Дата',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {
                $this->date = date("Y-m-d H:i:s");
            }

            return true;
        }
        return false;
    }

    /**
     * Возвращает отрицательный баланс или 0 сприкров ученика по замечаниям
     *
     * @param $pupilID
     * @return int|string
     */
    public static function getSuprikBalance($pupilID)
    {
        return EventNotes::find()
            ->where(['pupilID' => $pupilID])
            ->count();
    }
}
