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
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Lastupdate;
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
     * Lists all Vendor models.
     * @return mixed
     */
    public function actionIndex($id = '')
    {
        $categoryLinks              =   VendorCategoryLink::find()->select(['vendor_id'])->where(['category_id' => $id])->asArray()->all();
        $vendors                    =   \yii\helpers\ArrayHelper::getColumn($categoryLinks, 'vendor_id');

        $searchModel                =   new VendorSearch();
        $dataProvider               =   $searchModel->search(Yii::$app->request->queryParams, $vendors);
        $model                      =   new Vendor();
        $category                   =   Category::find()->select(['category_id', 'parent_category_id'])->where(['category_id' => $id])->asArray()->one();
        Vendor::$category_id        =   $id;
        $categoryModel              =   new Category();
        $categoryList               =   $categoryModel->getCategoryRoot($id);
        return $this->render('index', [
            'searchModel'   =>  $searchModel,
            'dataProvider'  =>  $dataProvider,
            'category'      =>  $category,
            'categoryList'  =>  $categoryList,
        ]);
    }

    /**
     * Displays a single Vendor model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id, $category = '')
    {
        $categoryModel              =   new Category();
        $categoryList               =   $categoryModel->getCategoryRoot($category);
        return $this->render('view', [
            'model'         =>  $this->findModel($id),
            'category'      =>  $category,
            'categoryList'  =>  $categoryList,
        ]);
    }

    /**
     * Creates a new Vendor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = '')
    {
        $model      = new Vendor();
        $category   = new Category();
        if ($model->load(Yii::$app->request->post())) 
        {
            $transaction                        =   Yii::$app->db->beginTransaction();
            $startDate                          =   \DateTime::createFromFormat('d-m-Y', $model->vendor_account_start_date);
            $endDate                            =   \DateTime::createFromFormat('d-m-Y', $model->vendor_account_end_date);
            $model->vendor_account_start_date   =   $startDate->format('Y-m-d');
            $model->vendor_account_end_date     =   $endDate->format('Y-m-d');
            $model->sort_order                  =   ($model->sort_order) ? $model->sort_order : 0;
            
            $request                            =   Yii::$app->request->post('Vendor');
            $error                              =   0;
            if($model->save())
            {
                #Updating last update table for vendor key
                #Updating last update table for area key
                $lastUpdate                       =   Lastupdate::find()->one();
                if($lastUpdate)
                {
                    $lastUpdate->vendor_key       =   Yii::$app->getSecurity()->generateRandomString(10);
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

                $vendorId                       =   $model->vendor_id;
                $logo                           =   UploadedFile::getInstance($model, 'vendor_logo');
                
                if($logo)
                {
                    $imageName                  =   "vendors/" . $vendorId . "/logo." . $logo->extension;
                    $vendorUpdate               =   Vendor::findOne(['vendor_id' => $vendorId]);
                    $vendorUpdate->vendor_logo  =   Yii::$app->resourceManager->getUrl($imageName);
                    if($vendorUpdate->update(false))
                        Yii::$app->resourceManager->save($logo, $imageName);
                }

                if(isset($request['vendor_category']) && !empty($request['vendor_category']))
                {
                    foreach($request['vendor_category'] As $category)
                    {
                        $vendorCategory                 = new VendorCategoryLink();
                        $vendorCategory->category_id    = $category;
                        $vendorCategory->vendor_id      = $vendorId;
                        if(!$vendorCategory->save())
                            $error  =   1;
                    }
                }
                
                if(isset($request['vendor_area']) && !empty($request['vendor_area']))
                {
                    foreach($request['vendor_area'] As $area)
                    {
                        $vendorArea                 = new VendorAreaLink();
                        $vendorArea->area_id        = $area;
                        $vendorArea->vendor_id      = $vendorId;
                        if(!$vendorArea->save())
                            $error  =   1;
                    }
                }

                $model->vendor_gallery = UploadedFile::getInstances($model, 'vendor_gallery');
                if($model->vendor_gallery)
                {
                    foreach($model->vendor_gallery AS $gallery)
                    {
                        $imageName                          = Yii::$app->getSecurity()->generateRandomString(10) . "." . $gallery->extension;
                        Yii::$app->resourceManager->save($gallery, "vendors/" . $vendorId . "/gallery/" . $imageName);

                        $modelGallery                       =   new VendorGallery();
                        $modelGallery->vendor_id            =   $vendorId;
                        $modelGallery->photo_url            =   Yii::$app->resourceManager->getUrl("vendors/" . $vendorId . "/gallery/" . $imageName);
                        $modelGallery->photo_added_datetime =   date('Y-m-d H:i:s');

                        if(!$modelGallery->save())
                            $error = 1;
                        else
                            Yii::$app->resourceManager->save($gallery, $imageName);
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
                return $this->redirect(['view', 'id' => $model->vendor_id, 'category' => $id]);
            }
        } 
        else 
        {
            return $this->render('create', [
                'model'         =>  $model,
                'categories'    =>  $category->getLeafCategories(),
                'areas'         =>  Area::find()->asArray()->all(),
                'categoryID'    =>  $id,
            ]);
        }
    }

    /**
     * Updates an existing Vendor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id, $categoryID = '')
    {

        $model      =   $this->findModel($id);
        $oldImage   =   $model->vendor_logo;

        $category   =   new Category();
        if ($model->load(Yii::$app->request->post()))
        {
            $transaction                        =   Yii::$app->db->beginTransaction();

            #Updating last update table for vendor key
            $lastUpdate                         =   Lastupdate::find()->one();
            $lastUpdate->vendor_key             =   Yii::$app->getSecurity()->generateRandomString(10);
            $lastUpdate->save();

            $startDate                          =   \DateTime::createFromFormat('d-m-Y', $model->vendor_account_start_date);
            $endDate                            =   \DateTime::createFromFormat('d-m-Y', $model->vendor_account_end_date);
            $model->vendor_account_start_date   =   $startDate->format('Y-m-d');
            $model->vendor_account_end_date     =   $endDate->format('Y-m-d');
            $model->sort_order                  =   ($model->sort_order) ? $model->sort_order : 0;
            
            $vendorId                           =   $model->vendor_id;
            $logo                               =   UploadedFile::getInstance($model, 'vendor_logo');
            if(!$logo)
                $model->vendor_logo             =   $oldImage;
            $error                              =   0;
            $request                            =   Yii::$app->request->post('Vendor');
            if($model->save())
            {
                if($logo)
                {
                    $imageName                  =   "vendors/" . $vendorId . "/logo." . $logo->extension;
                    $vendorUpdate               =   Vendor::findOne(['vendor_id' => $vendorId]);
                    $vendorUpdate->vendor_logo  =   Yii::$app->resourceManager->getUrl($imageName);

                    $model->deleteImage($imageName, 1); #Delete old vendor logo

                    if($vendorUpdate->update(false))
                        Yii::$app->resourceManager->save($logo, $imageName);
                }

                $vendorCategories               =   \yii\helpers\ArrayHelper::getColumn(VendorCategoryLink::find()
                        ->where(['vendor_id' => $model->vendor_id])
                        ->asArray()
                        ->all(), 'category_id');

                if(isset($request['vendor_category']) && !empty($request['vendor_category']))
                {
                    foreach($request['vendor_category'] As $category)
                    {
                        $index  =   array_search($category, $vendorCategories);
                        if($index !== FALSE)
                            unset($vendorCategories[$index]);
                        else
                        {
                            $vendorCategory                 = new VendorCategoryLink();
                            $vendorCategory->category_id    = $category;
                            $vendorCategory->vendor_id      = $vendorId;
                            if(!$vendorCategory->save())
                                $error  =   1;
                        }
                    }
                }

                VendorCategoryLink::deleteAll(['and', 'vendor_id = :id', ['in', 'category_id', $vendorCategories]], [':id' => $vendorId]);

                $vendorAreas                    =   \yii\helpers\ArrayHelper::getColumn(VendorAreaLink::find()
                        ->where(['vendor_id' => $model->vendor_id])
                        ->asArray()
                        ->all(), 'area_id');

                if(isset($request['vendor_area']) && !empty($request['vendor_area']))
                {
                    foreach($request['vendor_area'] As $area)
                    {
                        $index  =   array_search($area, $vendorAreas);
                        if($index !== FALSE)
                            unset($vendorAreas[$index]);
                        else
                        {
                            $vendorArea                 = new VendorAreaLink();
                            $vendorArea->area_id        = $area;
                            $vendorArea->vendor_id      = $vendorId;
                            if(!$vendorArea->save())
                                $error  =   1;
                        }
                    }
                }
                
                VendorAreaLink::deleteAll(['and', 'vendor_id = :id', ['in', 'area_id', $vendorAreas]], [':id' => $vendorId]);

                $model->vendor_gallery = UploadedFile::getInstances($model, 'vendor_gallery');
                if($model->vendor_gallery)
                {
                    foreach($model->vendor_gallery AS $gallery)
                    {
                        $imageName                          = Yii::$app->getSecurity()->generateRandomString(10) . "." . $gallery->extension;
                        Yii::$app->resourceManager->save($gallery, "vendors/" . $vendorId . "/gallery/" . $imageName);

                        $modelGallery                       =   new VendorGallery();
                        $modelGallery->vendor_id            =   $vendorId;
                        $modelGallery->photo_url            =   Yii::$app->resourceManager->getUrl("vendors/" . $vendorId . "/gallery/" . $imageName);
                        $modelGallery->photo_added_datetime =   date('Y-m-d H:i:s');

                        if(!$modelGallery->save())
                            $error = 1;
                        else
                            Yii::$app->resourceManager->save($gallery, $imageName);
                    }
                }

                if($error)
                    $transaction->rollback();
                else
                    $transaction->commit();

            }

            return $this->redirect(['view', 'id' => $model->vendor_id, 'category' => $categoryID]);
        } 
        else 
        {
            $categoryLinks  =   \yii\helpers\ArrayHelper::getColumn(\backend\models\VendorCategoryLink::find()
                ->select(['category_id'])
                ->where(['vendor_id' => $model->vendor_id])
                ->asArray()
                ->all(), 'category_id');

            $areaLinks      =   \yii\helpers\ArrayHelper::getColumn(\backend\models\VendorAreaLink::find()
                ->select(['area_id'])
                ->where(['vendor_id' => $model->vendor_id])
                ->asArray()
                ->all(), 'area_id');

            $model->vendor_category             = $categoryLinks;
            $model->vendor_area                 = $areaLinks;
            $startDate                          =   \DateTime::createFromFormat('Y-m-d', $model->vendor_account_start_date);
            $endDate                            =   \DateTime::createFromFormat('Y-m-d', $model->vendor_account_end_date);
            $model->vendor_account_start_date   =   $startDate->format('d-m-Y');
            $model->vendor_account_end_date     =   $endDate->format('d-m-Y');
            
            return $this->render('update', [
                'model'         =>  $model,
                'categories'    =>  $category->getLeafCategories(),
                'areas'         =>  Area::find()->asArray()->all(),
                'category'      =>  $categoryID,
            ]);
        }
    }

    /**
     * Deletes an existing Vendor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $category = '')
    {
        #Updating last update table for vendor key
        $lastUpdate                     =   Lastupdate::find()->one();
        $lastUpdate->vendor_key         =   Yii::$app->getSecurity()->generateRandomString(10);
        $lastUpdate->save();
        
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'id' => $category]);
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

    /**
    * Delete vendor gallery through ajax
    * @method POST
    * @param number gallery vendor gallery id
    * @return object returns the json object
    */
    public function actionDelete_gallery()
    {
        if(Yii::$app->request->isAjax)
        {
            $gallery = VendorGallery::findOne(['gallery_id' =>  Yii::$app->request->post('gallery')]);
            if($gallery)
            {
                $galleryUrl     =   $gallery->photo_url;
                if($gallery->delete())
                {
                    $model      =   new Vendor();
                    $model->deleteImage($galleryUrl, 2);
                    return json_encode(['status' => 200]);
                }
                else
                    return json_encode(['status' => 401]);
            }
            else
                return json_encode(['status' => 401]);
        }
    }
}