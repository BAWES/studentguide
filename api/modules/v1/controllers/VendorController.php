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
       Yii::$app->language     =   $language;
        $request                =   Yii::$app->request;
        $model                  =   new $this->modelClass;
        $query                  =   $model->find()
           ->select([new \yii\db\Expression('CONCAT("'.Yii::$app->request->hostinfo.'/common/uploads/'.'",{{%vendor}}.vendor_logo) as logo'),'{{%vendor}}.*'])
           ->asArray()->all();
        if($query)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "VENDOR_LIST"), 'data' => ['vendors' => $query]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "VENDOR_NOT_FOUND"), 'data' => (Object)[]];
    }


    public function actionCategorylink()
    {
        $rows = (new \yii\db\Query())
      ->select('*')
      ->from('{{%vendor_category_link}}')
      ->all();
      if($rows)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "CATEGORY_LINKS"), 'data' => ['category_link' => $rows]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "CATEGORY_LINKS"), 'data' => (Object)[]];
    }

    public function actionArealink()
    {
        $rows = (new \yii\db\Query())
      ->select('*')
      ->from('{{%vendor_area_link}}')
      ->all();
      if($rows)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "AREA_LINKS"), 'data' => ['area_link' => $rows]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "AREA_LINKS"), 'data' => (Object)[]];
    }


   public function actionVendorgallery()
    {
        $rows = (new \yii\db\Query())
      ->select([new \yii\db\Expression('CONCAT("'.Yii::$app->request->hostinfo.'/common/uploads/gallery/'.'",photo_url) as photo'), 'vendor_id'])
      ->from('{{%vendor_gallery}}')
      ->all();
      if($rows)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "VENDOR_GALLERY"), 'data' => ['vendor_gallery' => $rows]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "VENDOR_GALLERY"), 'data' => (Object)[]];
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
      $body = $data['name'].', Requested '.$data['message'].'';
      $send = Yii::$app->mailer->compose([
            "html" => "layouts/enquiry"
                ],[
            "message" => $body,
            "mobile" => $data['mobile']
           ])
          ->setFrom('sivabalan.s@technoduce.com')
          ->setTo('mariyappan@technoduce.com')
          ->setSubject('Enquiry from customer - Student Quide')
          ->send();
     if($send)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "mail"), 'data' => ['status' => 1]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "mail"), 'data' => ['status' => 0]];
    }
}