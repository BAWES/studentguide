<?php

namespace common\models;

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
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [];
        return [
            [['parent_category_id', 'category_vendors_filterable_by_area'], 'integer'],
            [['category_name_en', 'category_name_ar'], 'required'],
            [['category_created_datetime', 'category_updated_datetime'], 'safe'],
            [['category_name_en', 'category_name_ar'], 'string', 'max' => 255],
            [['parent_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_category_id' => 'category_id']],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id'                           => Yii::t('api', 'Category ID'),
            'parent_category_id'                    => Yii::t('api', 'Parent Category ID'),
            'category_name_en'                      => Yii::t('api', 'Category Name En'),
            'category_name_ar'                      => Yii::t('api', 'Category Name Ar'),
            'category_vendors_filterable_by_area'   => Yii::t('api', 'Category Vendors Filterable By Area'),
            'category_created_datetime'             => Yii::t('api', 'Category Created Datetime'),
            'category_updated_datetime'             => Yii::t('api', 'Category Updated Datetime'),
        ];
    }

    public function getCategory($category)
    {
        return $sql = Category::find()->select('category_id')->where(['like','category_name_en',$category])->asArray()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'parent_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorCategoryLinks()
    {
        return $this->hasMany(VendorCategoryLink::className(), ['category_id' => 'category_id']);
    }
}