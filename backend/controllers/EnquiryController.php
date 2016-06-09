<?php

namespace backend\controllers;

use Yii;
use backend\models\Enquiry;
use backend\models\EnquirySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * EnquiryController implements the CRUD actions for Enquiry model.
 */
class EnquiryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'index', 'view', 'update', 'delete', 'delete_gallery'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Enquiry models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel        = new EnquirySearch();
        $dataProvider       = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['created_datetime' => SORT_DESC]];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}