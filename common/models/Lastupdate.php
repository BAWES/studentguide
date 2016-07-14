<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%last_update}}".
 *
 * @property string $id
 * @property string $device_token
 * @property string $token_type
 * @property string $category_key
 * @property string $vendor_key
 * @property string $area_key
 * @property string $offer_key
 */
class Lastupdate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%last_update}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'category_key'  => Yii::t('app', 'Category Key'),
            'vendor_key'    => Yii::t('app', 'Vendor Key'),
            'area_key'      => Yii::t('app', 'Area Key'),
            'offer_key'     => Yii::t('app', 'Offer Key'),
        ];
    }

    /* Checking last update */
    public static function checkUpdate($field, $key)
    {
        return $check_update = self::find()
            ->select($field)
            ->where([$field => $key])
            ->count();
    }

    /* Check category key */
    public static function getKey($field)
    {
        return $check_device = self::find()
            ->select([$field])
            ->asArray()
            ->one();
    }
}
