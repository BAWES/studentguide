<?php

namespace backend\models;
use Yii;

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
            [['parent_category_id', 'category_vendors_filterable_by_area'], 'integer'],
            [['category_name_en', 'category_name_ar'], 'required'],
            [['category_created_datetime', 'category_updated_datetime'], 'safe'],
            [['category_name_en', 'category_name_ar'], 'string', 'max' => 255],
            [['parent_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_category_id' => 'category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => Yii::t('app', 'Category ID'),
            'parent_category_id' => Yii::t('app', 'Parent Category ID'),
            'category_name_en' => Yii::t('app', 'Category Name En'),
            'category_name_ar' => Yii::t('app', 'Category Name Ar'),
            'category_vendors_filterable_by_area' => Yii::t('app', 'Category Vendors Filterable By Area'),
            'category_created_datetime' => Yii::t('app', 'Category Created Datetime'),
            'category_updated_datetime' => Yii::t('app', 'Category Updated Datetime'),
        ];
    }

    /**
    * Get the parent categories
    * @return array returns parent categories
    */
    public function getParentCategories()
    {
        return self::find()->select(['p.category_id', 'p.category_name_en'])->join('join', '{{%category}} AS p', 'p.category_id = {{%category}}.parent_category_id')->asArray()->all();
    }

    /**
    * Get all the categories
    * @return array returns all the categories
    */
    public function getCategoryList()
    {
        return self::find()->select(['category_id', 'category_name_en'])->asArray()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getParentCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'parent_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getVendorCategoryLinks()
    {
        return $this->hasMany(VendorCategoryLink::className(), ['category_id' => 'category_id']);
    }*/
}