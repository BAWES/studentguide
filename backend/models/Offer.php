<?php 
namespace backend\models;

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
class Offer extends \common\models\Offer
{
	/** 
	 * @inheritdoc
	 */
	private $_width, $_height;

	public function rules()
	{
		$offerImageSetting 	=	Setting::find()
			->select(['offer_image_height', 'offer_image_width'])
			->asArray()
			->one();
		$this->_width 		=	$offerImageSetting['offer_image_width'];
		$this->_height 		=	$offerImageSetting['offer_image_height'];
		
		return [
			[['name_en', 'name_ar', 'start_date', 'end_date', 'status'], 'required'],
			['image', 'required', 'on' => 'insert'],
			['sort_order', 'number'],
			[['name_en', 'name_ar'], 'string', 'max' => 255],
			['url', 'url', 'defaultScheme' => 'http'],
			['url', 'string'],
			['image', 'image', 'extensions' => ['png', 'jpg', 'gif'], 'minWidth' => $this->_width, 'maxWidth' => $this->_width, 'minHeight' => $this->_height, 'maxHeight' => $this->_height],
		];
	}

	/**
	 * @inheritdoc
	 */ 
	public function scenarios()
	{
		$scenarios 				=	parent::scenarios();
		$scenarios['insert']	=	['name_en', 'name_ar', 'url', 'start_date', 'end_date', 'status', 'sort_order', 'image', 'created_datetime'];
		$scenarios['update']	=	['name_en', 'name_ar', 'url', 'start_date', 'end_date', 'status', 'sort_order', 'image', 'modified_datetime'];		
		return $scenarios;
	}	

	/**
	 * @inheritdoc
	 */ 
	public function beforeSave($insert)
	{
		if($insert)
			$this->created_datetime		=	date('Y-m-d H:i:s');
		else
			$this->modified_datetime	=	date('Y-m-d H:i:s');
		return true;
	}

    /**
    * Delete vendor images from aws s3 bucket
    * @param string url holds the image url
    * @return number 1 for success, 0 for failure
    */
    public function deleteImage($url)
    {
        $urlParts   =   explode("/", $url);
        $count      =   count($urlParts) - 1;
        $start      =   $count - 1;
        $fileName   =   [];
        for($i = $start; $i <= $count; $i++)
        {
        	if(isset($urlParts[$i]))
            	$fileName[] = $urlParts[$i];
        }

        Yii::$app->resourceManager->delete(implode("/", $fileName));
    }	
}