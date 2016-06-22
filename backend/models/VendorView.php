<?php

namespace backend\models;

use Yii;
use backend\models\Vendor;
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
class VendorView extends \common\models\VendorView
{
    public function getVendors()
    {
        return Vendor::find()->select(['vendor_id', 'vendor_name_en', 'vendor_name_ar'])->asArray()->all();
    }   
}
