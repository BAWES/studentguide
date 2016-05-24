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
        $query                  =   $model->find()
            ->select(['category' => '{{%category}}.category_id', 'category_en' => '{{%category}}.category_name_en', 'category_ar' => '{{%category}}.category_name_ar', 'parent_category' => 'IF({{%category}}.parent_category_id IS NULL, "", {{%category}}.parent_category_id)', 'filter_by' => '{{%category}}.category_vendors_filterable_by_area', 'count' =>   'count(p.category_id)'])
            ->leftJoin('{{%category}} AS p', '{{%category}}.category_id = p.parent_category_id');
        
        if($request->get('category'))
            $query->where(['{{%category}}.parent_category_id' => $request->get('category')]);
        else
            $query->where(['{{%category}}.parent_category_id' => NULL]);

        $categories = $query->groupBy(['p.parent_category_id'])->orderBy('{{%category}}.category_id DESC')->asArray()->all();
        if($categories)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "testing"), 'data' => ['categories' => $categories]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "testing"), 'data' => (Object)[]];
    }
}