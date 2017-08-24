<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "marks".
 *
 * @property integer $id
 * @property integer $eventID
 * @property string $pupilID
 * @property integer $test
 * @property integer $test_theme
 * @property integer $test_lesson
 * @property integer $lights
 * @property integer $active
 * @property integer $suprik
 */
class Marks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'marks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['eventID', 'test', 'test_theme', 'test_lesson', 'lights', 'active', 'suprik'], 'integer'],
            [['pupilID'], 'string', 'max' => 255],
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
            'test' => 'Test',
            'test_theme' => 'Test Theme',
            'test_lesson' => 'Test Lesson',
            'lights' => 'Lights',
            'active' => 'Active',
            'suprik' => 'Суприки',
        ];
    }

    /**
     * Возвращает или создает новую модель
     *
     * @param $eventID
     * @param $pupilID
     * @return Marks|static
     */
    public static function getOrCreateModel($eventID, $pupilID)
    {
        $model = Marks::findOne(['eventID' => $eventID, 'pupilID' => $pupilID]);
        if ($model) {
            return $model;
        }
        else {
            $model = new Marks();
            $model->eventID = $eventID;
            $model->pupilID = $pupilID;
            $model->save();
            return $model;
        }
    }

    /*
     * Перед сохранением начисляем суприки
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $this->calcSuprik();

            return true;
        }
        return false;
    }

    /**
     * Вычисляем суприки
     */
    private function calcSuprik()
    {
        $suprik = 0;

        if ($this->active != null) {
            if ($this->active == 1) $suprik++;
            else $suprik--;
        }
        if ($this->test_lesson != null) {
            if ($this->test_lesson >= 80) $suprik++;
            else $suprik--;
        }
        if ($this->lights != null) {
            if ($this->lights == 1) $suprik++;
            else $suprik--;
        }

        $this->suprik = $suprik;
    }

    /**
     * Возвращает кодичество суприков ученика за все ивенты
     *
     * @param $pupilID
     * @return int|mixed
     */
    public static function getSuprikFromEvents($pupilID)
    {
        $models = Marks::find()
                    ->select('suprik')
                    ->where(['pupilID' => $pupilID])
                    ->all();

        $suprik = 0;
        foreach ($models as $model) {
            $suprik += $model->suprik;
        }

        return $suprik;
    }
}
