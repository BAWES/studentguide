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
class DefaultcategoryController extends Controller
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
                        'actions'   =>  ['create', 'view', 'delete', 'update', 'index', 'view_category', 'get_category'],
                        'allow'     =>  true,
                        'roles'     =>  ['@'],
                    ],
                ],
            ],
            /*'verbs'     =>  [
                'class'     =>  VerbFilter::className(),
                'actions'   =>  [
                    'delete'    =>  ['POST'],
                ],
            ],*/
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model          =   new Category();

        return $this->render('index', [
            'categories'    =>  $model->getCategoryView(),
            'model'         =>  $model,
            'categoryList'  =>  $model->getCategoryList(),
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
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
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model'             =>  $model,
                'categories'        =>  $model->getCategoryList(),
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = Category::findOne(['category_id' => Yii::$app->request->post('Category')['category_id']]);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $key = Yii::$app->getSecurity()->generatePasswordHash(rand(5,16));
            $update = Lastupdate::updateAll(['category_key'=>$key]);
            return $this->redirect(['index']);
        }
        else
        {

            return $this->render('update', [
                'model'             =>  $model,
                'categories'        =>  $model->getCategoryList(),
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
        $model->delete();

        Yii::warning("[Deleted Category] ".$model->category_name_en." category has been deleted", __METHOD__);

        $key = Yii::$app->getSecurity()->generatePasswordHash(rand(5,16));
        $update = Lastupdate::updateAll(['category_key'=>$key]);

        return $this->redirect(['index']);
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

    /**
    * Load category details into html template
    * @param int category id
    */
    public function actionView_category()
    {
        $expression =   new \yii\db\Expression("IFNULL(p.category_name_en, '') AS 'Parent category', IF({{%category}}.category_vendors_filterable_by_area = 0, 'Yes', 'No') AS 'Filterable by vendor area', DATE_FORMAT({{%category}}.category_created_datetime,'%b %d %Y %h:%i %p') AS 'Created datetime', DATE_FORMAT({{%category}}.category_updated_datetime,'%b %d %Y %h:%i %p') AS 'Updated datetime'");
        $category   =   Category::find()->select(['"Category Name (English)"' => '{{%category}}.category_name_en', '"Category Name (Arabic)"' => '{{%category}}.category_name_ar', $expression])->join('LEFT JOIN', '{{%category}} AS p', '{{%category}}.parent_category_id = p.category_id')->where(['{{%category}}.category_id' => Yii::$app->request->post('id')])->asArray()->one();
        $table = "<table class='table'>";
        foreach($category AS $key => $value)
            $table .= "<tr><th>" . $key . "</th><td>" . $value . "</td>";
        $table .= "</table>";
        echo json_encode(['status' => 200, 'category_details' => $table]);
    }

        /**
    * Load category details into html template
    * @param int category id
    */
    public function actionGet_category()
    {
        $category   =   Category::find()->where(['{{%category}}.category_id' => Yii::$app->request->post('id')])->asArray()->one();
        echo json_encode(['status' => 200, 'category' => $category]);
    }
}
