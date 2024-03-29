<?php

namespace backend\controllers;

use Yii;
use backend\models\Area;
use backend\models\AreaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Lastupdate;

/**
 * AreaController implements the CRUD actions for Area model.
 */
class AreaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'    =>  [
                'class'     =>  AccessControl::className(),
                'rules'     =>  [
                    [
                        'actions'   =>  ['create', 'view', 'delete', 'update', 'index'],
                        'allow'     =>  true,
                        'roles'     =>  ['@'],
                    ],
                ],
            ],
            'verbs'     => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Area models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest)
            $this->redirect(['site/login']);
        else
        {
            $searchModel = new AreaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single Area model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Area model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Area();

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            #Updating last update table for area key
            $lastUpdate                     =   Lastupdate::find()->one();
            if($lastUpdate)
            {
                $lastUpdate->area_key           =   Yii::$app->getSecurity()->generateRandomString(10);
                $lastUpdate->save();
            }
            else
            {
                $modelUpdate                  =   new Lastupdate();
                $modelUpdate->category_key    =   Yii::$app->getSecurity()->generateRandomString(8);
                $modelUpdate->vendor_key      =   Yii::$app->getSecurity()->generateRandomString(8);
                $modelUpdate->area_key        =   Yii::$app->getSecurity()->generateRandomString(8);
                $modelUpdate->save();
            }
            
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Area model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            #Updating last update table for vendor key
            $lastUpdate                     =   Lastupdate::find()->one();
            $lastUpdate->area_key           =   Yii::$app->getSecurity()->generateRandomString(10);
            $lastUpdate->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Area model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        #Updating last update table for vendor key
        $lastUpdate                     =   Lastupdate::find()->one();
        $lastUpdate->area_key           =   Yii::$app->getSecurity()->generateRandomString(10);
        $lastUpdate->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Area model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Area the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Area::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}