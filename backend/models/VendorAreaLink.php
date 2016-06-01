<?php

namespace backend\models;

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
class VendorAreaLink extends \common\models\VendorAreaLink
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vendor_id', 'area_id'], 'required'],
            [['vendor_id', 'area_id'], 'integer'],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['area_id' => 'id']],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['vendor_id' => 'vendor_id']],
        ];
    }
}