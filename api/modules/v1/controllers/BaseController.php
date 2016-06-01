<?php
/**
* Base Class for the version one rest api controller
*/
namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use Yii;
use common\models\Lastupdate;
use common\models\PushNotification;

class BaseController extends ActiveController
{
	public $modelClass		=	"common\models\User";

	#Defining API status codes
	const STATUS_SUCCESS 	=	200;
	const STATUS_FAILURE	=	422;

	public function actions()
	{
		$actions = parent::actions();
		unset($actions['index'], $actions['create'], $actions['update'], $actions['delete']);
		return $actions;
	}

	/**
	* Check the whether device token exists or not.
	* If not exists insert the device token and send the device tokens
	* @method GET
	* @param number device_type indicates the device type (1 = Android, 2 = iOS)
	* @param string device_token indicates the device_token
	* @return object returns the keys
	*/
	public function actionSetting()
	{
		$request		=	Yii::$app->request;
		$deviceToken 	=	$request->get('device_token');
		$deviceType 	=	$request->get('device_type');
		if($deviceToken && $request->get('device_type'))
		{
			$model 	=	PushNotification::findOne(['device_token' => $deviceToken]);
			if(!$model)
			{
				$model 					=	new PushNotification();
				$model->device_type		=	$deviceType;
				$model->device_token   	=	$deviceToken;
				$model->save();
			}

			$update 		= 	Lastupdate::find()->select(['category_key', 'vendor_key', 'area_key'])->one();

			if($update)
	            return ['code' => self::STATUS_SUCCESS, 'message' => Yii::t("api", "testing"), 'data' => ['keys' => $update, 'terms' => '<h1>Terms and conditions</h1>']];
	        else
	            return ['code' => self::STATUS_FAILURE, 'message' => Yii::t("api", "testing"), 'data' => (Object)[]];
	    }
	    else
	    	return ['code' => self::STATUS_FAILURE, 'message' => Yii::t("api", "DEVICE_TOKEN_MANDATORY"), 'data' => (Object)[]];
	}

	/**
	* Change the user prefered language
	* @method GET
	* @param string device_token indicates the device token
	* @return object json object
	*/
	public function actionChange_language()
	{
		$request			=	Yii::$app->request;
		$deviceToken 		=	$request->get('device_token');
		$language 			=	$request->get('language');
		Yii::$app->language =	$language;
		
		if($deviceToken && $language)
		{
			$model 				=	PushNotification::findOne(['device_token' => $deviceToken]);
			$model->language 	=	$language;
			if($model->update() || !$model->isAttributeChanged($model->language))
				return ['code' => self::STATUS_SUCCESS, 'message' => Yii::t("api", "LANGUAGE_CHANGED"), 'data' => (Object)[]];
			else
			{
				
				return ['code' => self::STATUS_FAILURE, 'message' => Yii::t("api", "INVAILD_DEVICE_TOKEN"), 'data' => (Object)[]];
			}
		}
		else
	    	return ['code' => self::STATUS_FAILURE, 'message' => Yii::t("api", "FIELDS_MANDATORY"), 'data' => (Object)[]];
	}
}