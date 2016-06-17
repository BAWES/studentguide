<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%vendor}}".
 *
 * @property string $vendor_id
 * @property string $vendor_logo
 * @property string $vendor_name_en
 * @property string $vendor_name_ar
 * @property string $vendor_description_en
 * @property string $vendor_description_ar
 * @property string $vendor_phone1
 * @property string $vendor_phone2
 * @property string $vendor_youtube_video
 * @property string $vendor_social_instagram
 * @property string $vendor_social_twitter
 * @property string $vendor_location
 * @property string $vendor_address_text_en
 * @property string $vendor_address_text_ar
 * @property string $vendor_account_start_date
 * @property string $vendor_account_end_date
 *
 * @property VendorAreaLink[] $vendorAreaLinks
 * @property VendorCategoryLink[] $vendorCategoryLinks
 * @property VendorGallery[] $vendorGalleries
 * @property VendorView[] $vendorViews
 */
class Vendor extends \yii\db\ActiveRecord
{
    public $vendor_category, $vendor_area, $vendor_gallery;
    public $categoryList = [];
    public static $category_id = 10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vendor}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vendor_name_en', 'vendor_name_ar', 'vendor_phone1', 'vendor_account_start_date', 'vendor_account_end_date'], 'required'],
            [['vendor_description_en', 'vendor_description_ar'], 'string'],
            [['vendor_account_start_date', 'vendor_account_end_date'], 'safe'],
            [['vendor_logo', 'vendor_name_en', 'vendor_name_ar'], 'string', 'max' => 255],
            [['vendor_phone1', 'vendor_phone2'], 'string', 'max' => 15],
            [['vendor_youtube_video', 'vendor_address_text_en', 'vendor_address_text_ar'], 'string', 'max' => 512],
            [['vendor_social_instagram', 'vendor_social_twitter', 'vendor_youtube_video'], 'url'],
            [['vendor_social_instagram', 'vendor_social_twitter'], 'string', 'max' => 1024],
            [['vendor_location'], 'string', 'max' => 128],
            ['sort_order', 'number'],
            ['vendor_website', 'url', 'defaultScheme' => 'http'],
            ['vendor_website', 'string', 'max' => '256'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vendor_id' => Yii::t('app', 'Vendor ID'),
            'vendor_logo' => Yii::t('app', 'Vendor Logo'),
            'vendor_name_en' => Yii::t('app', 'Vendor Name (English)'),
            'vendor_name_ar' => Yii::t('app', 'Vendor Name (Arabic)'),
            'vendor_description_en' => Yii::t('app', 'Vendor Description (English)'),
            'vendor_description_ar' => Yii::t('app', 'Vendor Description (Arabic)'),
            'vendor_phone1' => Yii::t('app', 'Vendor Phone1'),
            'vendor_phone2' => Yii::t('app', 'Vendor Phone2'),
            'vendor_youtube_video' => Yii::t('app', 'Vendor Youtube Video'),
            'vendor_social_instagram' => Yii::t('app', 'Vendor Social Instagram'),
            'vendor_social_twitter' => Yii::t('app', 'Vendor Social Twitter'),
            'vendor_location' => Yii::t('app', 'Vendor Location'),
            'vendor_address_text_en' => Yii::t('app', 'Vendor Address (English)'),
            'vendor_address_text_ar' => Yii::t('app', 'Vendor Address (Arabic)'),
            'vendor_account_start_date' => Yii::t('app', 'Vendor Account Start Date'),
            'vendor_account_end_date' => Yii::t('app', 'Vendor Account End Date'),
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            Yii::info("[New Vendor - ".$this->vendor_name_en."] ".$this->vendor_description_en, __METHOD__);
        }
        else
        {
            Yii::info("[Updated Vendor - ".$this->vendor_name_en."] ".$this->vendor_description_en, __METHOD__);
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorAreaLinks()
    {
        return $this->hasMany(VendorAreaLink::className(), ['vendor_id' => 'vendor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorCategoryLinks()
    {
        return $this->hasMany(VendorCategoryLink::className(), ['vendor_id' => 'vendor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorGalleries()
    {
        return $this->hasMany(VendorGallery::className(), ['vendor_id' => 'vendor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorViews()
    {
        return $this->hasMany(VendorView::className(), ['vendor_id' => 'vendor_id']);
    }

    /**
    * Get the vendor related categories
    * @param number id indicates the vendor id
    * @return string html template with category template
    */
    public function getCategories($id)
    {
        $categories = self::find()
            ->select(['{{%category}}.category_id', 'category_name_en', 'category_name_ar'])
            ->join("join", "{{%vendor_category_link}}", "{{%vendor_category_link}}.vendor_id = {{%vendor}}.vendor_id")
            ->join("join", "{{%category}}", "{{%category}}.category_id = {{%vendor_category_link}}.category_id")
            ->where(['{{%vendor}}.vendor_id' => $id])
            ->asArray()
            ->all();

        $template   =   '';
        if($categories)
        {
            $template   =   "<table><thead><tr><th>Category (English)</th><th>Category (Arabic)</th><th>View</th</tr></thead>";
            $template   .=   "<tbody>";
            foreach($categories AS $category)
            {
                $template   .=  "<tr>";
                $template   .=  "<td>" . $category['category_name_en'] . "</td>";
                $template   .=  "<td>" . $category['category_name_ar'] . "</td>";
                $template   .=  "<td><a title='View Category' target='_blank' href='" . \yii\helpers\Url::to(['/category/view', 'id' => $category['category_id']] ) . "'><i class='fa fa-eye'></i></a></td>";
                $template   .=  "</tr>";
            }
            $template   .=   "</tbody></table>";
        }

        return $template;
    }

    /**
    * Get the vendor related areas
    * @param number id indicates the vendor id
    * @return string html template with area template
    */
    public function getAreas($id)
    {
        $areas = self::find()
            ->select(['{{%area}}.id', 'area_name_en', 'area_name_ar'])
            ->join("join", "{{%vendor_area_link}}", "{{%vendor_area_link}}.vendor_id = {{%vendor}}.vendor_id")
            ->join("join", "{{%area}}", "{{%area}}.id = {{%vendor_area_link}}.area_id")
            ->where(['{{%vendor}}.vendor_id' => $id])
            ->asArray()
            ->all();

        $template   =   '';
        if($areas)
        {
            $template   =   "<table><thead><tr><th>Area (English)</th><th>Area (Arabic)</th><th>View</th</tr></thead>";
            $template   .=   "<tbody>";
            foreach($areas AS $area)
            {
                $template   .=  "<tr>";
                $template   .=  "<td>" . $area['area_name_en'] . "</td>";
                $template   .=  "<td>" . $area['area_name_ar'] . "</td>";
                $template   .=  "<td><a title='View Category' target='_blank' href='" . \yii\helpers\Url::to(['/area/view', 'id' => $area['id']] ) . "'><i class='fa fa-eye'></i></a></td>";
                $template   .=  "</tr>";
            }
            $template   .=   "</tbody></table>";
        }

        return $template;
    }

    /**
    * Get the vendor galleries
    * @param number id indicates the vendor id
    * @param number action include action button or not default not include
    * @return string html template with galleries template
    */
    public function getGalleries($id, $action = 0)
    {
        $galleries = self::find()
            ->select(['gallery_id', 'photo_url'])
            ->join("join", "{{%vendor_gallery}}", "{{%vendor_gallery}}.vendor_id = {{%vendor}}.vendor_id")
            ->where(['{{%vendor}}.vendor_id' => $id])
            ->asArray()
            ->all();

        $template   =   '';
        if($galleries)
        {
            $template   =   "<div class='row'>";
            foreach($galleries AS $gallery)
            {
                $template       .=  "<div class = 'col-sm-6 col-md-3'><div class = 'thumbnail'><img class='vendor_gallery' src='" .$gallery['photo_url'] . "'/>";
                if($action)
                    $template   .=  "<div class='caption'><a id='" . $gallery['gallery_id'] ."' class='btn btn-warning pull-right gallery_action' href='#'>Remove</a></div>";
                $template       .=  "</div></div>";
            }
            $template           .=   "</div>";
        }

        return $template;
    }

    /**
    * Delete vendor images from aws s3 bucket
    * @param string url holds the image url
    * @param number action holds whether delete logo or gallery image, 1 for logo, 2 for
    * gallery
    * @return number 1 for success, 0 for failure
    */
    public function deleteImage($url, $action = 1)
    {
        //$url = "";
        $urlParts   =   explode("/", $url);
        $count      =   count($urlParts) - 1;
        $start      =   ($action == 1) ? $count - 2 : $count - 3;
        $fileName   =   [];
        for($i = $start; $i <= $count; $i++)
            $fileName[] = $urlParts[$i];

        Yii::$app->resourceManager->delete(implode("/", $fileName));
    }

    /**
    * Get Parent category list for the leaf category
    * @param int category leaf category id
    * @return string category path
    */
    public function getCategoryList($category_id)
    {
        $category   =   Category::find()->select(['p.category_id', 'p.category_name_en'])->join('JOIN', '{{%category}} AS p', '{{%category}}.parent_category_id = p.category_id')->where(['{{%category}}.category_id' => $category_id])->asArray()->one();
        if($category)
        {
            $this->categoryList[] =   $category['category_name_en'];
            $this->getCategoryList($category['category_id']);
        }

        return $this->categoryList;
    }
}
