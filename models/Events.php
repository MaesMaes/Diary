<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property integer $id
 * @property string $name
 * @property integer $subject
 * @property string $date
 * @property integer $moderator
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'moderator'], 'integer'],
            [['date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'subject' => 'Предмет',
            'date' => 'Дата проведения',
            'moderator' => 'Модератор',
        ];
    }

    public function getPupil()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('events_users', ['event_id' => 'id']);
    }

    /**
     * Удалим все связи с текущем id
     */
    private function clearCurrentPupils()
    {
        EventsUsers::deleteAll(['event_id' => $this->id]);
    }

    public function savePupils( $pupils )
    {
        if(is_array($pupils))
        {
            //Удалим все связи с текущем id
            $this->clearCurrentPupils();

            foreach($pupils as $pupilId)
            {
                $pupil = User::findOne($pupilId);
                $this->link('pupil', $pupil);
            }
        }
    }
}
