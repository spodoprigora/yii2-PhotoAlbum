<?php

namespace common\models\photo;

use Yii;

/**
 * This is the model class for table "photo_album".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $display_order
 * @property integer $active
 *
 * @property PhotoImage[] $photoImages
 */
class PhotoAlbum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photo_album';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['display_order', 'active'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'display_order' => 'Display Order',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotoImages()
    {
        return $this->hasMany(PhotoImage::className(), ['album_id' => 'id']);
    }


}
