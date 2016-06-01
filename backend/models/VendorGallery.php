<?php

namespace backend\models;

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
class VendorGallery extends \common\models\VendorGallery
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vendor_id', 'photo_url', 'photo_added_datetime'], 'required'],
            [['vendor_id'], 'integer'],
            [['photo_added_datetime'], 'safe'],
            [['photo_url'], 'string', 'max' => 255],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['vendor_id' => 'vendor_id']],
        ];
    }
}