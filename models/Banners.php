<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banners".
 *
 * @property integer $id
 * @property string $URLs
 * @property string $roleIDs
 * @property integer $place
 */
class Banners extends \yii\db\ActiveRecord
{
    const PLACES = [
        1 => 'Профиль'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['URLs', 'roleIDs'], 'string', 'max' => 255],
            [['place'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'URLs' => 'Изображения',
            'roleIDs' => 'Роли',
            'place' => 'Расположение'
        ];
    }

    /**
     * Записывает имя файла в качестве свойства модели
     * и сохраняет ее без валидации.
     *
     * @param $fileName
     * @return bool
     */
    public function saveImage($fileName)
    {
        $this->URLs = $fileName;

        /**
         * Сохраняем без валидации т.к. в модели присутствуют
         * и другие поля требующие валидации (описаны в скоупе rules)
         */
        return $this->save(false);
    }

    public function saveImages($imageName)
    {
        $images = json_decode($this->URLs);

        $tmp = [];
        $tmp = array_merge($tmp, (array)$images, [$imageName]);

        $this->URLs = json_encode($tmp);
        $this->save(false);
    }

    public function deleteImages($imageName)
    {
        $images = json_decode($this->URLs);


        $images = array_flip($images); //Меняем местами ключи и значения
        unset ($images[$imageName]) ; //Удаляем элемент массива
        $images = array_flip($images); //Меняем местами ключи и значения

        $this->URLs = json_encode($images);
        $this->save(false);
    }

    public static function getUploadPath()
    {
        return Yii::getAlias('@web') . 'tmp/banners';
    }
}
