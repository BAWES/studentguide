<?php 
namespace backend\models;

use Yii;

class PushNotificationHistory extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return '{{%push_notification_history}}';
	}

	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'message_en'  	=> Yii::t('app', 'Message (English)'),
            'message_ar'	=> Yii::t('app', 'Message (Arabic) '),
            'datetime'		=> Yii::t('app', 'Datetime'),
        ];
    }
}