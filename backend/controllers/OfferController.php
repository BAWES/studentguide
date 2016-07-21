<?php

namespace backend\controllers;

use Yii;
use backend\models\Offer;
use backend\models\OfferSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Lastupdate;
use yii\web\UploadedFile;

/**
 * OfferController implements the CRUD actions for Offer model.
 */
class OfferController extends Controller
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
     * Lists all Offer models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest)
            $this->redirect(['site/login']);
        else
        {
            $searchModel = new OfferSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single Offer model.
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
     * Creates a new Offer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model              =   new Offer();
        $model->scenario    =   "insert";
        if ($model->load(Yii::$app->request->post())) 
        {
            $image              =   UploadedFile::getInstance($model, 'image');
                
            if($image)
            {
                $imageName      =   "offers/" . Yii::$app->getSecurity()->generateRandomString(8) . "." . $image->extension;
                $model->image   =   Yii::$app->resourceManager->getUrl($imageName);
                Yii::$app->resourceManager->save($image, $imageName);
            }
            if($model->save())
            {
                #Updating last update table for offer key
                $lastUpdate                         =   Lastupdate::find()->one();
                if($lastUpdate)
                {
                    $lastUpdate->offer_key          =   Yii::$app->getSecurity()->generateRandomString(10);
                    $lastUpdate->save();
                }
            
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                return $this->render('create', [
                    'model' => $model,
                ]); 
            }
        } 
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Offer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model              =   $this->findModel($id);
        $model->scenario    =   "update";
        $oldImage           =   $model->image;
        if ($model->load(Yii::$app->request->post()))
        {
            $image                          =   UploadedFile::getInstance($model, 'image');
            if($image)
            {
                $imageName                  =   "offers/" . Yii::$app->getSecurity()->generateRandomString(8) . "." . $image->extension;
                $model->image               =   Yii::$app->resourceManager->getUrl($imageName);
                Yii::$app->resourceManager->save($image, $imageName);
                if($oldImage)
                    $model->deleteImage($oldImage); #Delete old vendor logo
            }
            else
                $model->image               =   $oldImage;

            if($model->update())
            {
                #Updating last update table for offer key
                $lastUpdate                     =   Lastupdate::find()->one();
                $lastUpdate->offer_key          =   Yii::$app->getSecurity()->generateRandomString(10);
                $lastUpdate->save();

                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } 
        else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Offer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model  =   $this->findModel($id);
        $image  =   $model->image;
        if($model->delete())
            $model->deleteImage($image); #Delete offer image

        #Updating last update table for offer key
        $lastUpdate                      =   Lastupdate::find()->one();
        $lastUpdate->offer_key           =   Yii::$app->getSecurity()->generateRandomString(10);
        $lastUpdate->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Offer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Offer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Offer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
