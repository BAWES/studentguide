<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\PushNotificationHistory;
use backend\models\PushNotificationHistorySearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;


class PushnotificationhistoryController extends Controller{
	public function behaviors()
	{
		return [
			'access'	=>	[
				'class'	=>	AccessControl::className(),
				'rules'	=>	[
					[
						'actions'	=>	['index'],
						'allow'		=>	true,
						'roles'		=>	['@'],
					]
				]
			]
		];
	}

	/**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
    	$searchModel	=	new PushNotificationHistorySearch();
    	$dataProvider	=	$searchModel->search(Yii::$app->request->queryParams);

    	return $this->render('index', [
    		'searchModel' 	=>	$searchModel,
    		'dataProvider'	=>	$dataProvider,
    	]);
    }
}