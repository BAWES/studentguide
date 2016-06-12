<?php

namespace backend\controllers;

use Yii;
use backend\models\Vendor;
use backend\models\VendorView;
use backend\models\VendorViewSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
/**
 * VendorController implements the CRUD actions for Vendor model.
 */
class VendorviewController extends Controller
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
                        'actions' => ['index'],
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
     * Lists all Vendor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel                = new VendorviewSearch();
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel'   =>  $searchModel,
            'dataProvider'  =>  $dataProvider,
        ]);
    }
}