<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "albums".
 *
 * @property integer $id
 * @property integer $creatorID
 * @property string $name
 * @property string $images
 */
class Albums extends \yii\db\ActiveRecord
{
    public static $savePath = 'uploads/albums/';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'albums';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creatorID'], 'integer'],
            [['name', 'images'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creatorID' => 'Создатель',
            'name' => 'Название',
            'images' => 'Фото',
        ];
    }

    /**
     * @inheritdoc
     * @return AlbumsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlbumsQuery(get_called_class());
    }

    public function saveImages($imageName)
    {
        $photo = new Photo();
        $photo->albumID = $this->id;
        $photo->url = $imageName;
        $photo->active = false;
        $photo->save(false);
    }

    public function deleteImageFile($imageId)
    {
        $photo = Photo::findOne($imageId);
        unlink(self::$savePath . $this->id . '/' . $photo->url);

        $photo->delete();
    }
}
