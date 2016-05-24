<?php
/**
* Base Class for the version one rest api controller
*/
namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use Yii;

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
	/*public function actionIndex1()
	{
		$object = new $this->modelClass;
		var_dump($object);
		echo Yii::t('api', 'testing');
		echo "hhh";
	}*/
}