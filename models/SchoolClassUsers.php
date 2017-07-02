<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "school_class_users".
 *
 * @property integer $school_class_id
 * @property integer $users_id
 */
class SchoolClassUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'school_class_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['school_class_id', 'users_id'], 'required'],
            [['school_class_id', 'users_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'school_class_id' => 'School Class ID',
            'users_id' => 'Users ID',
        ];
    }
}
