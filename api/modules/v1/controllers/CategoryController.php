<?php

namespace api\modules\v1\controllers;

use yii\web\Controller;
use Yii;

/**
 * Default controller for the `v1` module
 */
class CategoryController extends BaseController
{
    public $modelClass = "common\models\Category";
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['index'], $actions['update'], $actions['delete']);
        return $actions;
    }
    
    /**
    * Returns the category list
    * @param string language points the language code
    * @param number category points the category id, if it is empty returns the parent 
    * category list
    */
    public function actionIndex($language = "en")
    {
    	Yii::$app->language    =	$language;
        $request                =   Yii::$app->request;
        $model                  =   new $this->modelClass;
        $query                  =   $model->find();
        $query->select(['category_id','IFNULL(parent_category_id,0) as parent_category_id','category_name_en',
            'category_name_ar','category_vendors_filterable_by_area']);
        $categories = $query->orderBy('{{%category}}.category_id DESC')->asArray()->all();
        if($categories)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "testing"), 'data' => ['categories' => $categories]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "testing"), 'data' => (Object)[]];
    }
}