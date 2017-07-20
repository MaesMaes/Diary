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
 * @property string $place
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
            [['name', 'place'], 'string', 'max' => 255],
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
            'place' => 'Место проведения'
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

    public function savePupils( $pupils, $delete = true )
    {
        if(is_array($pupils) && !empty($pupils))
        {
            //Удалим все связи с текущем id
            if ($delete)
                $this->clearCurrentPupils();

            foreach($pupils as $pupilId)
            {
                $pupil = User::findOne($pupilId);
//                echo '<pre>'; print_r($pupil->events); die;
                if ($pupil->events[0]->id != $this->id)
                    $this->link('pupil', $pupil);
            }
        }
    }

    /**
     * Возвращает оценку за текущее событие у ученика
     *
     * @param $eventId
     * @return int|string
     */
    public static function getCurrentPupilPoint($eventId)
    {
        $pupilId = Yii::$app->user->id;
        if (User::isRole(User::USER_TYPE_PARENT))
            $pupilId = User::findOne(Yii::$app->user->id)->child ?? 0;

        if ($pupilId === 0) return '';

        return Points::findOne(['user_id' => $pupilId, 'event_id' => $eventId])->point ?? '';
    }
}
