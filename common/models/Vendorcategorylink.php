<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sg_vendor_category_link".
 *
 * @property string $link_id
 * @property string $vendor_id
 * @property string $category_id
 *
 * @property Category $category
 * @property Vendor $vendor
 */
class Vendorcategorylink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vendor_category_link}}';
    }

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['vendor_id', 'category_id'], 'required'],
            [['vendor_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'category_id']],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['vendor_id' => 'vendor_id']],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'link_id' => Yii::t('api', 'Link ID'),
            'vendor_id' => Yii::t('api', 'Vendor ID'),
            'category_id' => Yii::t('api', 'Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['vendor_id' => 'vendor_id']);
    }
}
