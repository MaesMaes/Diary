<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "options".
 *
 * @property integer $id
 * @property string $prop
 * @property string $value
 */
class Options extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prop', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prop' => 'Prop',
            'value' => 'Value',
        ];
    }
}
