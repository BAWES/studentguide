<?php

namespace api\modules\v1\controllers;

use yii\web\Controller;
use Yii;
use common\models\Category;

/**
 * Default controller for the `v1` module
 */
class VendorController extends BaseController
{
    public $modelClass = "common\models\Vendor";
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

        Yii::$app->language    = $language;
        $request                =   Yii::$app->request;
        $model                  =   new $this->modelClass;
        $query                  =   $model->find();

        if($request->get('vendor'))
         {
           $query->where(['=','{{%vendor}}.vendor_id',$request->get('vendor')]);
         }
        
         /* Main category search*/
         if($request->get('category'))
         {
              $query->join('INNER JOIN','{{%vendor_category_link}}','{{%vendor_category_link}}.vendor_id = {{%vendor}}.vendor_id')
             ->where(['{{%vendor_category_link}}.category_id' => $request->get('category')]);
             /* When search inside main category */
             if($request->get('search'))
             $query->andWhere(['like','{{%vendor}}.vendor_name_en',$request->get('search')]);
         }

         /* Sub category search*/
         if($request->get('subcategory'))
         {
              $query->join('INNER JOIN','{{%vendor_category_link}}','{{%vendor_category_link}}.vendor_id = {{%vendor}}.vendor_id')
             ->leftjoin('{{%category}}','{{%category}}.parent_category_id = {{%vendor_category_link}}.category_id')
             ->where(['{{%vendor_category_link}}.category_id' => $request->get('subcategory')]);
             /* When search inside main category */
             if($request->get('search'))
             $query->andWhere(['like','{{%vendor}}.vendor_name_en',$request->get('search')]);
         }

         /* Area search*/
         if($request->get('area'))
         {
              $query->join('INNER JOIN','{{%vendor_area_link}}','{{%vendor_area_link}}.vendor_id = {{%vendor}}.vendor_id')
              ->leftjoin('{{%category}}','{{%category}}.parent_category_id = {{%vendor_category_link}}.category_id')
             ->where(['{{%vendor_area_link}}.area_id' => $request->get('area')])
             ->andWhere(['{{%category}}.category_vendors_filterable_by_area' => 1]);
             /* When search inside main category */
             if($request->get('search'))
             $query->andWhere(['like','{{%vendor}}.vendor_name_en',$request->get('search')]);
         }


         /* Search for all   */
         if($request->get('search'))
         {
           $query->select('{{%vendor}}.*, {{%area}}.*')
          //->leftjoin('{{%vendor_category_link}}','{{%vendor_category_link}}.vendor_id = {{%vendor}}.vendor_id')
          //->leftjoin('{{%category}}','{{%category}}.category_id = {{%vendor_category_link}}.category_id')
          ->leftjoin('{{%vendor_area_link}}','{{%vendor_area_link}}.vendor_id = {{%vendor}}.vendor_id')
          ->leftjoin('{{%area}}','{{%area}}.id = {{%vendor_area_link}}.area_id')
          //->where(['like','{{%category}}.category_name_en',$request->get('search')])
          ->where(['like','{{%vendor}}.vendor_name_en',$request->get('search')])
          ->orWhere(['like','{{%area}}.area_name_en',$request->get('search')])
          ->groupby('{{%vendor}}.vendor_id');
         }
         $vendors = $query->asArray()->all();
        if($vendors)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "vendors"), 'data' => ['vendors' => $vendors]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "VENDOR_NOT_FOUND"), 'data' => (Object)[]];
    }

   public function actionArealists($language = "en")
   {
        Yii::$app->language    = $language;
        $request                =   Yii::$app->request;
        $model                  =   new $this->modelClass;
        $query                  =   $model->find();

        $rows = (new \yii\db\Query())
      ->select('*')
      ->from('{{%area}}')
      ->all();
      if($rows)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "areas"), 'data' => ['vendors' => $rows]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "areas"), 'data' => (Object)[]];
    }

    public function actionEnquiry()
    {
     if(Yii::$app->request->post())
      $data = Yii::$app->request->post();
      $body = $data['name']. 'requested '.$data['message'].'';
      $send = Yii::$app->mailer->compose([
            "html" => "layouts/enquiry"
                ],[
            "message" => $body,
            "mobile" => $data['mobile']
           ])
          ->setFrom('sivabalan.s@technoduce.com')
          ->setTo('khalid@bawes.net')
          ->setSubject('Enquiry from user')
          ->send();
     if($send)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "mail"), 'data' => ['status' => 1]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "mail"), 'data' => ['status' => 0]];
    }
}