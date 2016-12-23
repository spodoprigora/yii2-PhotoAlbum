<?php

namespace common\models\photo;

use Yii;

/**
 * This is the model class for table "photo_image".
 *
 * @property integer $id
 * @property integer $album_id
 * @property string $image
 * @property string $title
 * @property string $alt
 * @property string $description
 * @property integer $display_order
 *
 * @property PhotoAlbum $album
 */
class PhotoImage extends \yii\db\ActiveRecord
{

    public $filePath = 'files/photo';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photo_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id', 'image'], 'required'],
            [['album_id', 'display_order'], 'integer'],
            [['description'], 'string'],
            [['image'], 'string', 'max' => 255],
            [['title', 'alt'], 'string', 'max' => 50],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => PhotoAlbum::className(), 'targetAttribute' => ['album_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'album_id' => 'Album ID',
            'image' => 'Image',
            'title' => 'Title',
            'alt' => 'Alt',
            'description' => 'Description',
            'display_order' => 'Display Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(PhotoAlbum::className(), ['id' => 'album_id']);
    }

    public function getImagePath()
    {

        return '/' . $this->filePath . '/' . $this->image;
    }


}
