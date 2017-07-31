<?php
/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 11.06.17
 * Time: 18:32
 */

namespace app\models;


use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class ImageUpload
 *
 * @package app\models
 */
class ImageUpload extends Model
{
    public $image;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg,png']
        ];
    }

    /**
     * @param UploadedFile $file - загружаемый файл
     * @param $currentImage - текующая картинка модели
     * @return string
     */
    public function uploadFile(UploadedFile $file, $currentImage)
    {
        $this->image = $file;

        //Удалим старую картинку если она была
        $this->deleteCurrentImage($currentImage);

        //Если картинка имеет формат png || jpg
        if ($this->validate())
        {
            //Сохраняем картинку
            return $this->saveImage();
        }
    }

    private function getFolder()
    {
        return Yii::getAlias('@web') . 'uploads/';
    }

    private function generateFileName()
    {
        return strtolower(md5(uniqid($this->image->name))) . '.' . $this->image->extension;
    }

    public function deleteCurrentImage($currentImage)
    {
        if ($this->fileExists($currentImage)) {
            unlink($this->getFolder() . $currentImage);
        }
    }

    private function saveImage()
    {
        //Генерируем уникальное имя
        $fileName = $this->generateFileName();

        /**
         * Сохраняет файл по пути /Users/jscheq/Documents/git/Treasure/web
         * + uploads/ + имя файла
         */
        $this->image->saveAs($this->getFolder() . $fileName);

        return $fileName;
    }

    private function fileExists($currentImage)
    {
        if (!empty($currentImage) && $currentImage != null)
        {
            return file_exists($this->getFolder() . $currentImage);
        }
    }
}