<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%vendor_area_link}}".
 *
 * @property string $link_id
 * @property string $vendor_id
 * @property integer $area_id
 *
 * @property Area $area
 * @property Vendor $vendor
 */
class VendorAreaLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vendor_area_link}}';
    }

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['vendor_id', 'area_id'], 'required'],
            [['vendor_id', 'area_id'], 'integer'],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['area_id' => 'id']],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['vendor_id' => 'vendor_id']],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'link_id' => Yii::t('app', 'Link ID'),
            'vendor_id' => Yii::t('app', 'Vendor ID'),
            'area_id' => Yii::t('app', 'Area ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['vendor_id' => 'vendor_id']);
    }
}