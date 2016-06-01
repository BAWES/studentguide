<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%enquiry}}".
 *
 * @property string $enquiry_id
 * @property string $name
 * @property string $message
 * @property string $mobile
 * @property string $created_datetime
 * @property string $modified_datetime
 */
class Enquiry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%enquiry}}';
    }

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['message'], 'string'],
            [['created_datetime', 'modified_datetime'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 15],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'enquiry_id' => Yii::t('app', 'Enquiry ID'),
            'name' => Yii::t('app', 'Name'),
            'message' => Yii::t('app', 'Message'),
            'mobile' => Yii::t('app', 'Mobile'),
            'created_datetime' => Yii::t('app', 'Created Datetime'),
            'modified_datetime' => Yii::t('app', 'Modified Datetime'),
        ];
    }

    /* Before save function */
    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->created_datetime = date("Y-m-d H:i:s");
        }
        else
        {
            $this->modified_datetime = date("Y-m-d H:i:s");
        }
        return parent::beforeSave($insert);     
    }
}
