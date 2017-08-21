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
            [['eventID', 'test', 'test_theme', 'test_lesson', 'lights', 'active'], 'integer'],
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
        ];
    }
}
