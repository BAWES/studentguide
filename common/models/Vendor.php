<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sg_vendor".
 *
 * @property string $vendor_id
 * @property string $vendor_logo
 * @property string $vendor_name_en
 * @property string $vendor_name_ar
 * @property string $vendor_description_en
 * @property string $vendor_description_ar
 * @property string $vendor_phone1
 * @property string $vendor_phone2
 * @property string $vendor_youtube_video
 * @property string $vendor_social_instagram
 * @property string $vendor_social_twitter
 * @property string $vendor_location
 * @property string $vendor_address_text_en
 * @property string $vendor_address_text_ar
 * @property string $vendor_account_start_date
 * @property string $vendor_account_end_date
 *
 * @property VendorAreaLink[] $vendorAreaLinks
 * @property VendorCategoryLink[] $vendorCategoryLinks
 * @property VendorGallery[] $vendorGalleries
 * @property VendorView[] $vendorViews
 */
class Vendor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vendor}}';
    }

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['vendor_name_en', 'vendor_name_ar', 'vendor_phone1', 'vendor_account_start_date', 'vendor_account_end_date'], 'required'],
            [['vendor_description_en', 'vendor_description_ar'], 'string'],
            [['vendor_account_start_date', 'vendor_account_end_date'], 'safe'],
            [['vendor_logo', 'vendor_name_en', 'vendor_name_ar'], 'string', 'max' => 255],
            [['vendor_phone1', 'vendor_phone2'], 'string', 'max' => 15],
            [['vendor_youtube_video', 'vendor_address_text_en', 'vendor_address_text_ar'], 'string', 'max' => 512],
            [['vendor_social_instagram', 'vendor_social_twitter'], 'string', 'max' => 1024],
            [['vendor_location'], 'string', 'max' => 128],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vendor_id' => Yii::t('app', 'Vendor ID'),
            'vendor_logo' => Yii::t('app', 'Vendor Logo'),
            'vendor_name_en' => Yii::t('app', 'Vendor Name En'),
            'vendor_name_ar' => Yii::t('app', 'Vendor Name Ar'),
            'vendor_description_en' => Yii::t('app', 'Vendor Description En'),
            'vendor_description_ar' => Yii::t('app', 'Vendor Description Ar'),
            'vendor_phone1' => Yii::t('app', 'Vendor Phone1'),
            'vendor_phone2' => Yii::t('app', 'Vendor Phone2'),
            'vendor_youtube_video' => Yii::t('app', 'Vendor Youtube Video'),
            'vendor_social_instagram' => Yii::t('app', 'Vendor Social Instagram'),
            'vendor_social_twitter' => Yii::t('app', 'Vendor Social Twitter'),
            'vendor_location' => Yii::t('app', 'Vendor Location'),
            'vendor_address_text_en' => Yii::t('app', 'Vendor Address Text En'),
            'vendor_address_text_ar' => Yii::t('app', 'Vendor Address Text Ar'),
            'vendor_account_start_date' => Yii::t('app', 'Vendor Account Start Date'),
            'vendor_account_end_date' => Yii::t('app', 'Vendor Account End Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorAreaLinks()
    {
        return $this->hasMany(VendorAreaLink::className(), ['vendor_id' => 'vendor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorCategoryLinks()
    {
        return $this->hasMany(Vendorcategorylink::className(), ['vendor_id' => 'vendor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorGalleries()
    {
        return $this->hasMany(VendorGallery::className(), ['vendor_id' => 'vendor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorViews()
    {
        return $this->hasMany(VendorView::className(), ['vendor_id' => 'vendor_id']);
    }
}
