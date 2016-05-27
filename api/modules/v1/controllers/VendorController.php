<?php

namespace api\modules\v1\controllers;

use yii\web\Controller;
use Yii;
use common\models\Category;
use common\models\Enquiry;

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
           ->select([new \yii\db\Expression('CONCAT("'.Yii::$app->request->hostinfo.'/common/uploads/'.'",vendor_logo) as logo'), 'vendor_id', new \yii\db\Expression('CONCAT("'.Yii::$app->request->hostinfo.'/common/uploads/'.'",{{%vendor}}.vendor_logo) as vendor_logo'), 'vendor_name_en', 'vendor_name_ar', 'vendor_description_en', 'vendor_description_ar', 'vendor_phone1', 'IFNULL(vendor_phone2, "") AS vendor_phone2', 'IFNULL(vendor_youtube_video, "") AS vendor_youtube_video', 'IFNULL(vendor_social_instagram, "") AS vendor_social_instagram', 'IFNULL(vendor_social_twitter, "") AS vendor_social_twitter, IFNULL(vendor_location, "") AS vendor_location, IFNULL(vendor_address_text_en, "") AS vendor_address_text_en, IFNULL(vendor_address_text_ar, "") AS vendor_address_text_ar'])
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
      ->select([new \yii\db\Expression('CONCAT("'.Yii::$app->request->hostinfo.'/common/uploads/gallery/'.'",photo_url) as photo'), 'vendor_id', 'gallery_id'])
      ->from('{{%vendor_gallery}}')
      ->all();
      if($rows)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "VENDOR_GALLERY"), 'data' => ['vendor_gallery' => $rows]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "VENDOR_GALLERY"), 'data' => (Object)[]];
    }

   public function actionArealist($language = "en")
   {
        Yii::$app->language     =   $language;
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

      /* New entry in enquiry table */
      $insert = new Enquiry();
      $insert->name = $data['name'];
      $insert->message = $data['message'];
      $insert->mobile = $data['mobile'];
      $insert->save();
      if($send)
              return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "mail"), 'data' => ['status' => 1]];
          else
              return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "mail"), 'data' => ['status' => 0]];
      } 
}