<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property integer $id
 * @property string $terms_and_conditions
 * @property string $contact_email
 */
class Setting extends \common\models\Setting
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['terms_and_conditions', 'contact_email', 'offer_image_width', 'offer_image_height'], 'required'],
            [['terms_and_conditions'], 'string'],
            [['contact_email'], 'string', 'max' => 255],
            ['contact_email', 'email'],
        ];
    }
}