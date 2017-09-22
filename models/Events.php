<?php

namespace app\models;

use DateTime;
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
 * @property string $task1
 * @property string $task2
 * @property string $event_title
 * @property boolean $spend
 */
class Events extends \yii\db\ActiveRecord
{
    public $eventTypes = [
        'Урок' => 'Урок',
        'Секция' => 'Секция',
        'Самостоятельная работа' => 'Самостоятельная работа',
        'Модуль' => 'Модуль',
        'Урок основной' => 'Урок основной',
        'Минигруппа' => 'Минигруппа',
    ];
    public static $eventTypesS = [
        'Урок' => 'Урок',
        'Секция' => 'Секция',
        'Самостоятельная работа' => 'Самостоятельная работа',
        'Модуль' => 'Модуль',
        'Урок основной' => 'Урок основной',
        'Минигруппа' => 'Минигруппа',
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
            [['date', 'spend', 'event_title'], 'safe'],
            [['name', 'place', 'theme', 'standard', 'deep', 'task1', 'task2'], 'string', 'max' => 255],
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
            'task1' => 'Задание 1',
            'task2' => 'Задание 2',
            'event_title' => 'Название',
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
     * @param bool $one - вернуть первый класс
     * @return array
     */
    public function getEventClasses($toString = false, $one = false)
    {
        $classes = [];
        $users = User::find()->joinWith('events')->where(['event_id' => $this->id])->all();
        foreach ($users as $user)
            if (!in_array($user->className, $classes))
                $classes[] = $user->className;

        if ($one)
            return ($classes[0] ?? '')
                ? $classes[0]
                : $classes[1] ?? '';

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

    /**
     * Вернет рабочие дни
     *
     * @param $count
     * @param string $clock
     * @return array
     */
    public static function getNoWeekendDays($count, $clock = ' 16:00:00')
    {
        $dates = [];
        $date = new DateTime();

        while(count($dates) < $count)
        {
            //Следующий день
            $date->setTimestamp(strtotime($date->format('Y-m-d H:i:s')) + 24 * 60 * 60);

            //Не выходной
            if (date('N', strtotime($date->format('Y-m-d'))) < 6) {
                $dates[] = $date->format('Y-m-d') . $clock;
            }
        }

        return $dates;
    }

    /**
     * Создает минигруппы
     *
     * @param $lastEvent - инфо о ивенте для групп: модератор и предмет
     * @param $pupils - список id учеников
     * @param $daysCount - количество дней
     */
    public static function createMiniGroup($lastEvent, $pupils, $daysCount)
    {
        $days = Events::getNoWeekendDays($daysCount);

        for($i = 0; $i < $daysCount; $i++) {
            $event = new Events();
            $event->moderator = $lastEvent->moderator;
            $event->subject = $lastEvent->subject;
            $event->duration = 45;
            $event->date = $days[$i];
            $event->name = 'Минигруппа';
            $event->save(false);
            $event->refresh();

            foreach ($pupils as $pupilID) {
                $eventUsers = new EventsUsers();
                $eventUsers->event_id = $event->id;
                $eventUsers->user_id = $pupilID;
                $eventUsers->save();
            }
        }
    }

    /**
     * Проверяет будем ли создавать минигруппы, устанавливает
     * свойство "Проведено", если свойство установлено создавать
     * не будем.
     *
     * @param $id
     * @return bool
     */
    public static function checkSpendStatusOfEvent($id)
    {
        $eventModel = Events::findOne($id);

        if (isset($eventModel->spend) && $eventModel->spend == true) return false;

        $eventModel->spend = true;
        $eventModel->save(false);

        return true;
    }

    /**
     * Возвращает цвет события в зависимости от названия класса
     */
    public function getEventColor()
    {
        $className = $this->getEventClasses(true, true);
//        print_r($className); die;
        $color = "LightGrey";

        if (isset($this->spend) && $this->spend == true)
            return $color;

        switch ($className) {
            case '0 а':
                return '#cc3a37';
            case '0 б':
                return '#e69301';
            case '0 г':
                return '#ebe300';
            case '1 а':
                return '#50b754';
            case '1 б':
                return '#38b7ab';
            case '2 а':
                return '#2228dc';
            case '3 а':
                return '#d602bb';
            case '5 а':
                return '#cc071f';
            default:
                return 'orange';
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->event_title = $this->getEventClasses(true) . ' ' . Subject::findOne($this->subject)->name;

            return parent::beforeSave($insert);
        } else {
            return false;
        }
    }
}
