<?php

namespace api\modules\v1\controllers;

use yii\web\Controller;
use Yii;
use common\models\Category;
use common\models\Enquiry;
use common\models\Lastupdate;

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

        // check last update
        $cacheData              =   Lastupdate::checkUpdate('vendor_key', $request->get('vendor_key')); 
        $cache                  =   1; // new entries            
        $current_key            =   Lastupdate::getKey('vendor_key');
        $key                    =   $current_key['vendor_key']; //  current key   

        if($cacheData == 1)
        {
            $cache              =   0;             
            $rows               =   (Object)[];  
        }
        else
        {

            $query              =   $model->find()
                ->select([new \yii\db\Expression('CONCAT("'.Yii::$app->request->hostinfo.'/common/uploads/'.'",vendor_logo) as logo'), 'vendor_id', new \yii\db\Expression('CONCAT("'.Yii::$app->request->hostinfo.'/common/uploads/'.'",{{%vendor}}.vendor_logo) as vendor_logo'), 'vendor_name_en', 'vendor_name_ar', 'vendor_description_en', 'vendor_description_ar', 'vendor_phone1', 'IFNULL(vendor_phone2, "") AS vendor_phone2', 'IFNULL(vendor_youtube_video, "") AS vendor_youtube_video', 'IFNULL(vendor_social_instagram, "") AS vendor_social_instagram', 'IFNULL(vendor_social_twitter, "") AS vendor_social_twitter, IFNULL(vendor_location, "") AS vendor_location, IFNULL(vendor_address_text_en, "") AS vendor_address_text_en, IFNULL(vendor_address_text_ar, "") AS vendor_address_text_ar', 'vendor_account_start_date', 'vendor_account_end_date'])
                ->asArray()
                ->all();
        }

        if($query)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "testing"), 'data' => ['vendor' => $query, 'key' => $key, 'cache' => $cache]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "VENDOR_NOT_FOUND"), 'data' => (Object)[]];
    }


    public function actionCategorylink($language = "en")
    {
        Yii::$app->language     =   $language;
        $request                =   Yii::$app->request;

        // check last update
        $cacheData              =   Lastupdate::checkUpdate('vendor_key', $request->get('vendor_key')); 
        $cache                  =   1; // new entries            
        $current_key            =   Lastupdate::getKey('vendor_key');
        $key                    =   $current_key['vendor_key']; //  current key   
        if($cacheData == 1)
        {
            $cache              =   0;             
            $rows               =   (Object)[];  
        }
        else
        {
            $rows               = (new \yii\db\Query())
                ->select('*')
                ->from('{{%vendor_category_link}}')
                ->all();
        }

        if($rows)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "testing"), 'data' => ['category_link' => $rows, 'key' => $key, 'cache' => $cache]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "CATEGORY_LINKS"), 'data' => (Object)[]];
    }

    public function actionArealink($language = "en")
    {
        Yii::$app->language     =   $language;
        $request                =   Yii::$app->request;

        // check last update
        $cacheData              =   Lastupdate::checkUpdate('vendor_key', $request->get('vendor_key')); 
        $cache                  =   1; // new entries            
        $current_key            =   Lastupdate::getKey('vendor_key');
        $key                    =   $current_key['vendor_key']; //  current key   
        if($cacheData == 1)
        {
            $cache              =   0;             
            $rows               =   (Object)[];  
        }
        else
        {
            $rows = (new \yii\db\Query())
                ->select('*')
                ->from('{{%vendor_area_link}}')
                ->all();
        }

        if($rows)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "AREA_LINKS"), 'data' => ['area_link' => $rows, 'key' => $key, 'cache' => $cache]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "AREA_LINKS"), 'data' => (Object)[]];
    }


    public function actionVendorgallery($language = "en")
    {
        Yii::$app->language     =   $language;
        $request                =   Yii::$app->request;

        // check last update
        $cacheData              =   Lastupdate::checkUpdate('vendor_key', $request->get('vendor_key')); 
        $cache                  =   1; // new entries            
        $current_key            =   Lastupdate::getKey('vendor_key');
        $key                    =   $current_key['vendor_key']; //  current key   
        if($cacheData == 1)
        {
            $cache              =   0;             
            $rows               =   (Object)[];  
        }
        else
        {
            $rows               = (new \yii\db\Query())
                ->select([new \yii\db\Expression('CONCAT("'.Yii::$app->request->hostinfo.'/common/uploads/gallery/'.'",photo_url) as photo'), 'vendor_id', 'gallery_id'])
                ->from('{{%vendor_gallery}}')
                ->all();
        }

        if($rows)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "testing"), 'data' => ['vendor_gallery' => $rows, 'key' => $key, 'cache' => $cache]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "VENDOR_GALLERY"), 'data' => (Object)[]];
    }

    public function actionArealist($language = "en")
    {
        Yii::$app->language     =   $language;
        $request                =   Yii::$app->request;
        $model                  =   new $this->modelClass;
        $query                  =   $model->find();

        // check last update
        $cacheData              =   Lastupdate::checkUpdate('area_key', $request->get('area_key')); 
        $cache                  =   1; // new entries            
        $current_key            =   Lastupdate::getKey('area_key');
        $key                    =   $current_key['area_key']; //  current key   
        if($cacheData == 1)
        {
            $cache              =   0;             
            $rows               =   (Object)[];  
        }
        else
        {
            $rows               = (new \yii\db\Query())
              ->select('*')
              ->from('{{%area}}')
              ->all();
        }
        
        if($rows)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "testing"), 'data' => ['vendors' => $rows, 'key' => $key, 'cache' => $cache]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "areas"), 'data' => (Object)[]];
    }

    public function actionEnquiry()
    {
        $to_email = \common\models\Setting::find()->asArray()->one();
        $data     = Yii::$app->request->post();
        $body     = $data['name'] . ', Requested ' . $data['message'];
        $send     = Yii::$app->mailer->compose(["html" => "layouts/enquiry"],  [
              "message" => $body,
              "mobile"  => $data['mobile']
            ])
            ->setFrom('mariyappan@technoduce.com')
            ->setTo('sivabalan.s@technoduce.com')
            ->setSubject('Enquiry from customer - Student Quide')
            ->send();
        
        /* New entry in enquiry table */
        $insert             = new Enquiry();
        $insert->name       = $data['name'];
        $insert->message    = $data['message'];
        $insert->mobile     = $data['mobile'];
        $insert->save();
        if($send)
            return ['code' => parent::STATUS_SUCCESS, 'message' => Yii::t("api", "mail"), 'data' => ['status' => 1]];
        else
            return ['code' => parent::STATUS_FAILURE, 'message' => Yii::t("api", "mail"), 'data' => ['status' => 0]];
    } 
}