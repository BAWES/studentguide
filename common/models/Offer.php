<?php 
namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%offers}}"
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ar
 * @property string $url
 * @property string $image
 * @property string $start_date
 * @property string $end_date
 */
class Offer extends \yii\db\ActiveRecord{

	/** 
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return "{{%offers}}";
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' 				=>	Yii::t('app', 'ID'),
			'name_en' 			=>	Yii::t('app', 'Name (English)'),
			'name_ar' 			=>	Yii::t('app', 'Name (Arabic)'),
			'url' 				=>	Yii::t('app', 'URL'),
			'image' 			=>	Yii::t('app', 'Image'),
			'start_date' 		=>	Yii::t('app', 'Start Date'),
			'end_date' 			=>	Yii::t('app', 'End Date'),
			'status' 			=>	Yii::t('app', 'Status'),
			'sort_order'		=>	Yii::t('app', 'Sort Order'),
			'created_datetime' 	=>	Yii::t('app', 'Created Datetime'),
			'modified_datetime'	=>	Yii::t('app', 'Modified Datetime'),
		];
	}
}