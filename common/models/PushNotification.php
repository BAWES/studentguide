<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%push_notification}}".
 *
 * @property integer $id
 * @property integer $device_type
 * @property string $device_token
 */
class PushNotification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $message;
    public static function tableName()
    {
        return '{{%push_notification}}';
    }

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['message'], 'required'],
            [['device_type'], 'integer'],
            [['device_token'], 'string', 'max' => 255],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'device_type' => Yii::t('app', 'Device Type'),
            'device_token' => Yii::t('app', 'Device Token'),
        ];
    }
}
