<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%push_notification}}".
 *
 * @property integer $id
 * @property integer $device_type
 * @property string $device_token
 */
class PushNotification extends \common\models\PushNotification
{
    /**
     * @inheritdoc
     */
    public $message_en, $message_ar;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_en', 'message_ar'], 'required'],
            [['device_type'], 'integer'],
            [['device_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            =>  Yii::t('app', 'ID'),
            'device_type'   =>  Yii::t('app', 'Device Type'),
            'device_token'  =>  Yii::t('app', 'Device Token'),
            'message_en'    =>  Yii::t('app', 'Message (English)'),
            'message_ar'    =>  Yii::t('app', 'Message (Arabic)'),
        ];
    }
}
