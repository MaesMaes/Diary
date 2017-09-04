<?php

namespace app\models;

use Imagick;
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
        echo '<pre>'; print_r($images);

        foreach ($images as $img => $imgName)
            if ($imgName == $imageName)
                unset($images[$img]);

//        echo '<pre>'; print_r($images);

//        $images = array_flip($images); //Меняем местами ключи и значения
//        unset ($images[$imageName]) ; //Удаляем элемент массива
//        $images = array_flip($images); //Меняем местами ключи и значения

        $this->URLs = json_encode($images);
//        echo '<pre>'; print_r($this->URLs); die;

        $this->save(false);
    }

    public static function getUploadPath()
    {
        return Yii::getAlias('@web') . 'tmp/banners';
    }

    /**
     * Находит нужную ориентацию картинки
     *
     * @param $path - путь до шпега
     */
    public static function autoRotateImage($path) {
        $image = new Imagick($path);

        $orientation = $image->getImageOrientation();

        switch($orientation) {
            case Imagick::ORIENTATION_BOTTOMRIGHT:
                $image->rotateImage("#000", 180); // rotate 180 degrees
                break;

            case Imagick::ORIENTATION_RIGHTTOP:
                $image->rotateImage("#000", 90); // rotate 90 degrees CW
                break;

            case Imagick::ORIENTATION_LEFTBOTTOM:
                $image->rotateImage("#000", -90); // rotate 90 degrees CCW
                break;
        }

        // Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
        $image->setImageOrientation(Imagick::ORIENTATION_TOPLEFT);

        $image->writeImage($path);
    }
}
