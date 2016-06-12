<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sg_vendor".
 *
 * @property string $view_id
 * @property string $vendor_id
 * @property string $view_date
 * @property integer $number_of_views
 *
 * @property Vendor $vendor
 */
class VendorView extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vendor_view}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vendor_id', 'view_date'], 'required'],
            [['vendor_id', 'number_of_views'], 'integer'],
            ['vendor_id', 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['vendor_id' => 'vendor_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'view_id' => Yii::t('app', 'View ID'),
            'vendor_id' => Yii::t('app', 'Vendor Id'),
            'view_date' => Yii::t('app', 'Vendor Date'),
            'number_of_views' => Yii::t('app', 'Number of views'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasMany(Vendor::className(), ['vendor_id' => 'vendor_id']);
    }
}
