<?php

namespace backend\models;

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
class Area extends \common\models\Area
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_name_en', 'area_name_ar'], 'required'],
            [['area_name_en', 'area_name_ar'], 'string', 'max' => 255],
        ];
    }
}