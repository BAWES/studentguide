<?php

namespace backend\models;
use Yii;
use yii\helpers\Url;
/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $category_id
 * @property string $parent_category_id
 * @property string $category_name_en
 * @property string $category_name_ar
 * @property integer $category_vendors_filterable_by_area
 * @property string $category_created_datetime
 * @property string $category_updated_datetime
 *
 * @property Category $parentCategory
 * @property Category[] $categories
 * @property VendorCategoryLink[] $vendorCategoryLinks
 */
class Category extends \common\models\Category
{
    public $leafCategories  =   [];
    public $rootCategories  =   [];
    public $categories      =   '';

    /**
     * @inheritdoc
     */
    /*public static function tableName()
    {
        return '{{%category}}';
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_category_id', 'category_vendors_filterable_by_area', 'status'], 'integer'],
            [['category_name_en', 'category_name_ar'], 'required'],
            [['category_created_datetime', 'category_updated_datetime'], 'safe'],
            [['category_name_en', 'category_name_ar'], 'string', 'max' => 255],
            [['parent_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_category_id' => 'category_id']],
            ['category_id', 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id'                           => Yii::t('app', 'Category ID'),
            'parent_category_id'                    => Yii::t('app', 'Parent Category ID'),
            'category_name_en'                      => Yii::t('app', 'Category Name En'),
            'category_name_ar'                      => Yii::t('app', 'Category Name Ar'),
            'category_vendors_filterable_by_area'   => Yii::t('app', 'Category Vendors Filterable By Area'),
            'sort_order'                            => Yii::t('app', 'Sort order'),
            'category_created_datetime'             => Yii::t('app', 'Category Created Datetime'),
            'category_updated_datetime'             => Yii::t('app', 'Category Updated Datetime'),
        ];
    }

    public function beforeSave($insert)
    {
        if($insert){
            $this->category_created_datetime    =   date('Y-m-d H:i:s');
            Yii::info("[New Category] Created category ".$this->category_name_en, __METHOD__);
        }
        else{
            $this->category_updated_datetime    =   date('Y-m-d H:i:s');
            Yii::info("[Updated Category] Updated the category ".$this->category_name_en, __METHOD__);
        }

        return true;
    }

    /**
    * Get the parent categories
    * @return array returns parent categories
    */
    public function getParentCategories()
    {
        return self::find()
            ->select(['p.category_id', 'p.category_name_en'])
            ->join('join', '{{%category}} AS p', 'p.category_id = {{%category}}.parent_category_id')
            ->asArray()
            ->all();
    }

    /**
    * Get all the categories which doesn't have vendors under that
    * @return array returns all the categories
    */
    public function getCategoryList()
    {
        $vendorCategoryLink =   VendorCategoryLink::className();
        $query              =   $vendorCategoryLink::find()->select('category_id');
        return self::find()->select(['category_id', 'category_name_en'])->where(['not in', 'category_id', $query])->groupBy('category_id')->asArray()->all();
    }

    /**
    * Get all the child categories which doesn't have the sub categories anymore
    * @param null|number id indicates the parent category id
    * @return array returns the leaf categories
    */
    public function getLeafCategories($id = NULL)
    {
        $categories = self::find()->where(['parent_category_id' => $id])->asArray()->all();
        if($categories)
        {
            foreach($categories AS $category)
                $this->getLeafCategories($category['category_id']);
        }
        else
        {
            $subcategory = self::find()->select(['category_id', 'category_name_en'])->where(['category_id' => $id])->asArray()->one();
            $this->leafCategories[] = $subcategory;
        }
        return $this->leafCategories;
    }

    /**
    * Get category top lists
    * @param int category id
    * @return array category list
    */
    public function getCategoryRoot($categoryId)
    {
        $category                   =   self::find()->select(['p.category_id', 'p.category_name_en'])->join('JOIN', '{{%category}} AS p', 'p.category_id = {{%category}}.parent_category_id')->where(['{{%category}}.category_id' => $categoryId])->asArray()->one();

        if($category)
        {
            $categories                   =   self::find()->select(['category_id', 'category_name_en'])->where(['category_id' => $categoryId])->asArray()->one();
            $this->rootCategories[]       =   $categories;
            $this->getCategoryRoot($category['category_id']);
        }
        else
        {
            $category                   =   self::find()->select(['category_id', 'category_name_en'])->where(['category_id' => $categoryId])->asArray()->one();
            if($category)
                $this->rootCategories[] =   $category;
        }
        return array_reverse($this->rootCategories);
    }

    /**
    * Full Category Path for default category 
    * @param int category id
    */
    public function getCategoryView($category_id = NULL)
    {
        //$this->categories .= "<ul>";
        $expression =   new \yii\db\Expression('IFNULL(parent_category_id, 0) AS parent_category_id');
        $categories = self::find()->select(['category_id', 'category_name_en', 'category_name_ar', $expression])->where(['parent_category_id' => $category_id])->asArray()->all();
        foreach($categories AS $category)
        {
            /*$this->categories .= "<td class='" . (($category_id) ? $category_id : 'base'). "'>"  . $category['category_name_en'] . ' ' . $category['category_name_ar'];*/
            $this->categories .= "<tr data-id='" . $category['category_id'] . "' data-parent='" . (($category_id) ? $category_id : '') . "'>";
            $this->categories .= "<td>" . $category['category_name_en'] . "</td>";
            $this->categories .= "<td>" . $category['category_name_ar'] . "</td>";
            $vendorCount        =   self::find()->select(['category_id', 'category_name_en', 'category_name_ar', $expression])->join('JOIN', '{{%vendor_category_link}} AS vl', '{{%category}}.category_id = vl.category_id')->where(['{{%category}}.category_id' => $category['category_id']])->count();
            $this->categories .= "<td>";
            if(!$vendorCount)
                $this->categories .= '<a class="actions add_category" data-attribute-id="' . $category['category_id'] . '" data-attribute-name="' . $category['category_name_en'] . '"><i class="fa fa-plus fa-fw"></i></a>';
            $this->categories .= "<a class='actions view' id='" . $category['category_id'] . "' href='#'><i class='fa fa-eye fa-fw'></i></a><a id='" . $category['category_id'] . "' class='actions update' href='#'><i class='fa fa-edit fa-fw'></i></a><a class='actions' onclick='return confirm(\"Are you sure want to delete?\")' href='" . Url::to(['defaultcategory/delete', 'id' => $category['category_id']]) . "'><i class='fa fa-trash fa-fw fa-1x'></i></a></td>";
            $this->categories .= "</tr>";
            if($category)
                $this->getCategoryView($category['category_id']);
            //$this->categories .= "</li>";
        }
        //$this->categories .= "</tr>";
        return $this->categories;
    }

    /**
    * Category Drop down list
    * @param int category id
    * @return string holds the category list
    */
    public function getCategoryDropDownList($category_id = NULL)
    {
        //$this->categories .= "<ul>";
        $expression =   new \yii\db\Expression('IFNULL(parent_category_id, 0) AS parent_category_id');
        $categories = self::find()->select(['category_id', 'category_name_en', 'category_name_ar', $expression])->where(['parent_category_id' => $category_id])->asArray()->all();
        foreach($categories AS $category)
        {
            $subCategoryCount        =   self::find()->join('JOIN', '{{%category}} AS child', '{{%category}}.category_id = child.parent_category_id')->where(['{{%category}}.category_id' => $category['category_id']])->count();
            $this->categories .= "<tr data-id='" . $category['category_id'] . "' data-parent='" . (($category_id) ? $category_id : '') . "'>";
            if(!$subCategoryCount)
                $this->categories .= '<td><input type="checkbox" id="' . $category['category_id'] . '" name="Vendor[vendor_category][]" value="' . $category['category_id'] . '"/>&nbsp;<label class="checkbox_label" for="' . $category['category_id'] . '">' . $category['category_name_en'] . '</label></td>';
            else
                $this->categories .= "<td>"  . $category['category_name_en'] . "</td>";
            $this->categories .= "</tr>";
            if($category)
                $this->getCategoryDropDownList($category['category_id']);
        }
        //$this->categories .= "</tr>";
        return $this->categories;
    }
}
