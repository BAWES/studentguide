<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%area}}".
 *
 * @property integer $id
 * @property string $area_name_en
 * @property string $area_name_ar
 *
 * @property VendorAreaLink[] $vendorAreaLinks
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%area}}';
    }

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['area_name_en', 'area_name_ar'], 'required'],
            [['area_name_en', 'area_name_ar'], 'string', 'max' => 255],
        ];
    }*/

    public function beforeSave($insert)
    {
        if($insert){
            Yii::info("[New Area] Created area -> ".$this->area_name_en, __METHOD__);
        }
        else{
            Yii::info("[Updated Area] Updated area -> ".$this->area_name_en, __METHOD__);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'area_name_en' => Yii::t('app', 'Area Name En'),
            'area_name_ar' => Yii::t('app', 'Area Name Ar'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorAreaLinks()
    {
        return $this->hasMany(VendorAreaLink::className(), ['area_id' => 'id']);
    }
}
