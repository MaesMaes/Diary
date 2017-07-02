<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "school_class".
 *
 * @property integer $id
 * @property string $name
 */
class SchoolClass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'school_class';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'name' => 'Класс',
        ];
    }

    public function getPupil()
    {
        return $this->hasMany(User::className(), ['id' => 'users_id'])
            ->viaTable('school_class_users', ['school_class_id' => 'id']);
    }

    /**
     * Получить сохраненные тэги статьи
     */
    public function getSelectedUsers()
    {
        $selectedTags = $this->getPupil()->select('id')->asArray()->all();

        return ArrayHelper::getColumn($selectedTags, 'id');
    }

    /**
     * Удалим все связи с текущем id
     */
    private function clearCurrentClass()
    {
        SchoolClassUsers::deleteAll(['school_class_id' => $this->id]);
    }

    public function savePupils( $users )
    {
        if(is_array($users))
        {
            //Удалим все связи с текущем id
            $this->clearCurrentClass();

            foreach($users as $userId)
            {
                $user = User::findOne($userId);
                $this->link('pupil', $user);
            }
        }
    }
}
