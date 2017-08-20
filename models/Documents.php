<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documents".
 *
 * @property integer $id
 * @property integer $category
 * @property string $path
 * @property string $name
 */
class Documents extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $docFile;

    public $savePath = 'uploads/documents/';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category'], 'integer'],
            [['path', 'name'], 'string', 'max' => 255],
            [['docFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Категория',
            'path' => 'Путь',
            'name' => 'Наименование документа',
            'docFile' => 'Файл',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->docFile->saveAs($this->savePath . $this->docFile->baseName . '.' . $this->docFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
