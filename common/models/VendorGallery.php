<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%vendor_gallery}}".
 *
 * @property integer $gallery_id
 * @property string $vendor_id
 * @property string $photo_url
 * @property string $photo_added_datetime
 *
 * @property Vendor $vendor
 */
class VendorGallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vendor_gallery}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gallery_id' => Yii::t('app', 'Gallery ID'),
            'vendor_id' => Yii::t('app', 'Vendor ID'),
            'photo_url' => Yii::t('app', 'Photo Url'),
            'photo_added_datetime' => Yii::t('app', 'Photo Added Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['vendor_id' => 'vendor_id']);
    }
}