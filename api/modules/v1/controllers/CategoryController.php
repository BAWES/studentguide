<?php

namespace api\modules\v1\controllers;

use yii\web\Controller;
use Yii;
use yii\helpers\Security;
use common\models\Lastupdate;
use common\models\Offer;
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
        Yii::$app->language     =   $language;
        $request                =   Yii::$app->request;
        $model                  =   new $this->modelClass;

        // check last update
        $cacheData      =   Lastupdate::checkUpdate('category_key', $request->get('category_key')); 
        $cache          =   1; // new entries            
        $current_key    =   Lastupdate::getKey('category_key');
        $key            =   $current_key['category_key']; //  current key          
             
        /* Generate cache key */
        if($cacheData == 1)
        {       
            $cache                          =   0;             
            $categories                     =   (Object)[];  
        }
        else
        {
            $categories     =   $model->find()
            ->select(['category_id', 'IFNULL(parent_category_id, 0) as parent_category_id', 'category_name_en', 'category_name_ar', 'category_vendors_filterable_by_area'])
            ->orderBy('{{%category}}.category_id DESC')
            ->asArray()
            ->all();   
        }
        
        if($categories)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "testing"), 'data' => ['categories' => $categories, 'key' => $key, 'cache' => $cache]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "testing"), 'data' => (Object)[]];
    }

    /**
    * Returns the category list
    * @param string language points the language code
    * @return json
    */
    public function actionOffers($language = "en")
    {
        Yii::$app->language     =   $language;
        $request                =   Yii::$app->request;
        $model                  =   new Offer();

        $offers     =   $model->find()
            ->select(['offer_id' => 'id', 'name_en', 'name_ar', 'url', 'image', 'start_date', 'end_date'])
            ->orderBy('id DESC')
            ->where(['status' => 1])
            ->asArray()
            ->all();   
        
        if($offers)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "Offers retrieved successfully"), 'data' => ['offers' => $offers]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "No offers found"), 'data' => (Object)[]];
    }
}