<?php

namespace backend\controllers;

use Yii;
use backend\models\Area;
use backend\models\Category;
use backend\models\Vendor;
use backend\models\VendorSearch;
use backend\models\VendorCategoryLink;
use backend\models\VendorAreaLink;
use backend\models\VendorGallery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * VendorController implements the CRUD actions for Vendor model.
 */
class VendorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
        $searchModel = new VendorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vendor model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Vendor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model      = new Vendor();
        $category   = new Category();
        if ($model->load(Yii::$app->request->post())) 
        {
            $transaction                        = Yii::$app->db->beginTransaction();
            $startDate                          = \DateTime::createFromFormat('d-m-Y', $model->vendor_account_start_date);
            $endDate                            = \DateTime::createFromFormat('d-m-Y', $model->vendor_account_end_date);
            $model->vendor_account_start_date   =  $startDate->format('Y-m-d');
            $model->vendor_account_end_date     =  $endDate->format('Y-m-d');
            $request                            = Yii::$app->request->post('Vendor');
            $error                              = 0;
            if($model->save())
            {
                $vendorId                       = $model->vendor_id;
                if(isset($request['vendor_category']))
                {
                    foreach($request['vendor_category'] As $category)
                    {
                        $vendorCategory                 = new VendorCategoryLink();
                        $vendorCategory->category_id    = $category;
                        $vendorCategory->vendor_id      = $vendorId;
                        if(!$vendorCategory->save())
                        {
                            $error  =   1;
                        }
                    }
                }
                
                if(isset($request['vendor_area']))
                {
                    foreach($request['vendor_area'] As $area)
                    {
                        $vendorArea                 = new VendorAreaLink();
                        $vendorArea->area_id        = $area;
                        $vendorArea->vendor_id      = $vendorId;
                        if(!$vendorArea->save())
                        {
                            $error  =   1;
                            
                        }
                    }
                }
                $model->vendor_gallery = UploadedFile::getInstances($model, 'vendor_gallery');
                if($model->vendor_gallery)
                {
                    foreach($model->vendor_gallery AS $gallery)
                    {
                        $imageName                          = $gallery->baseName . "." . $gallery->extension;
                        //$gallery->saveAs('uploads/' . $imageName);
                        $modelGallery                       =   new VendorGallery();
                        $modelGallery->vendor_id            =   $vendorId;
                        $modelGallery->photo_url            =   $imageName;
                        $modelGallery->photo_added_datetime =   date('Y-m-d H:i:s');
                        if(!$modelGallery->save())
                            $error = 1;
                    }
                }
            }
            else
                $error = 1;
            
            if($error)
                $transaction->rollback();
            else
            {
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->vendor_id]);
            }
        } 
        else 
        {
            return $this->render('create', [
                'model'         =>  $model,
                'categories'    =>  $category->getLeafCategories(),
                'areas'         =>  Area::find()->asArray()->all(),
            ]);
        }
    }

    /**
     * Updates an existing Vendor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $category   = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->vendor_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories'    =>  $category->getLeafCategories(),
                'areas'         =>  Area::find()->asArray()->all(),
            ]);
        }
    }

    /**
     * Deletes an existing Vendor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Vendor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Vendor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vendor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}