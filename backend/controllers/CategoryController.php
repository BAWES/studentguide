<?php

namespace backend\controllers;

use Yii;
use backend\models\Category;
use backend\models\CategorySearch;
use backend\models\VendorCategoryLink;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Lastupdate;
use yii\filters\AccessControl;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
            'verbs'     =>  [
                'class'     =>  VerbFilter::className(),
                'actions'   =>  [
                    'delete'    =>  ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex($id = '')
    {
        $searchModel    =   new CategorySearch();
        $dataProvider   =   $searchModel->search(Yii::$app->request->queryParams, $id);
        if(VendorCategoryLink::find()->where(['category_id' => $id])->count())
            return $this->redirect(['vendor/index', 'id' => $id]);

        return $this->render('index', [
            'searchModel'           =>  $searchModel,
            'dataProvider'          =>  $dataProvider,
            'parent_category_id'    =>  $id,
            'category'              =>  ($id) ? Category::find()->where(['category_id' => $id])->asArray()->one() : '',
            'categoryList'          =>  $searchModel->getCategoryRoot($id),
        ]);
    }

    /**
     * Displays a single Category model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->redirect(['index', 'id' => $id]);
        //return $this->render('')
        /*return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = '')
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $key = Yii::$app->getSecurity()->generatePasswordHash(rand(5,16));
            #Updating last update table for area key
            $lastUpdate                     =   Lastupdate::find()->one();
            if($lastUpdate)
            {
                $lastUpdate->category_key   =   Yii::$app->getSecurity()->generateRandomString(10);
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
            return $this->redirect(['view', 'id' => $model->category_id]);
        } else {
            return $this->render('create', [
                'model'             =>  $model,
                'parentCategoryId'  =>  $id,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $key = Yii::$app->getSecurity()->generatePasswordHash(rand(5,16));
            $update = Lastupdate::updateAll(['category_key'=>$key]);
            return $this->redirect(['view', 'id' => $model->parent_category_id]);
        }
        else
        {
            return $this->render('update', [
                'model'             =>  $model,
                'parentCategoryId'  =>  $model->parent_category_id,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $categoryId = $model->parent_category_id;

        Yii::warning("[Deleted Category] ".$model->category_name_en." category has been deleted", __METHOD__);

        $model->delete();

        $key = Yii::$app->getSecurity()->generatePasswordHash(rand(5,16));
        $update = Lastupdate::updateAll(['category_key'=>$key]);

        return $this->redirect(['index', 'id' => $categoryId]);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
