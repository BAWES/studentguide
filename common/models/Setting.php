<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property integer $id
 * @property string $terms_and_conditions
 * @property string $contact_email
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'terms_and_conditions' => Yii::t('app', 'Terms And Conditions'),
            'contact_email' => Yii::t('app', 'Contact Email'),
        ];
    }
}