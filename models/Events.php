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
 * @property integer $duration
 * @property integer $moderator
 * @property string $place
 */
class Events extends \yii\db\ActiveRecord
{
    public $eventTypes = [
        'Урок' => 'Урок',
        'Секция' => 'Секция',
        'Самостоятельная работа' => 'Самостоятельная работа',
        'Модуль' => 'Модуль',
    ];

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
            [['subject', 'moderator', 'duration'], 'integer'],
            [['date'], 'safe'],
            [['name', 'place', 'theme', 'standard', 'deep',], 'string', 'max' => 255],
            [['duration'], 'default', 'value' => 45],
//            [['moderator'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тип события',
            'subject' => 'Предмет',
            'date' => 'Дата проведения',
            'duration' => 'Длительность (мин)',
            'moderator' => 'Модератор',
            'place' => 'Место проведения',
            'theme' => 'Тема',
            'standard' => 'Стандарт',
            'deep' => 'Углубление',
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

    /**
     * Возвращает названия классов участвующих в событии
     *
     * @param bool $toString - возвротить в виде строки
     * @return array
     */
    public function getEventClasses($toString = false)
    {
        $classes = [];
        $users = User::find()->joinWith('events')->where(['event_id' => $this->id])->all();
        foreach ($users as $user)
            if (!in_array($user->className, $classes))
                $classes[] = $user->className;

        if($toString) {
            $str = '';
            foreach ($classes as $class)
                $str .= $class . ' , ';

            return mb_substr($str, 0, -2);
        }

        return $classes;
    }

    /**
     * Возвращет id ивента по рефереру
     *
     * @param $link
     * @return mixed
     */
    public static function getEventID($link)
    {
        $queryParams = parse_url($link)['query'];
        parse_str($queryParams, $params);
        return $params['id'];
    }
}
