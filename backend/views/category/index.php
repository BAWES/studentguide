<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
if(!$categoryList)
    $this->params['breadcrumbs'][] = $this->title;
else
{
    $this->params['breadcrumbs'][] = ['url' => 'index', 'label' => $this->title];
    $count = count($categoryList) - 1;
    for($i = 0; $i <= $count; $i++)
    {
        if($i == $count)
            $this->params['breadcrumbs'][] = $categoryList[$i]['category_name_en'];
        else
            $this->params['breadcrumbs'][] = ['url' => Url::to(['index', 'id' => $categoryList[$i]['category_id']]), 'label' => $categoryList[$i]['category_name_en']];
    }
}
?>

<div class="category-index">

    <?php //var_dump($categoryList);// echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php 
            $vendorCreateButton = '';
            if(!$dataProvider->totalCount) 
                $vendorCreateButton =   Html::a(Yii::t('app', 'Create Vendor'), ['vendor/create', 'id' => $parent_category_id], ['class' => 'btn btn-success']);

            if($parent_category_id)
            {
                $categoryText   =   Yii::t('app', 'Create subcategory');
                echo Html::a($categoryText, ['create', 'id' => $parent_category_id], ['class' => 'btn btn-success']);
                echo $vendorCreateButton;
                echo Html::a('Back', ['index', 'id' => $category['parent_category_id']], ['class' => 'btn btn-default']);
            }
            else
            {
                $category   =   Yii::t('app', 'Create category');
                echo Html::a($category, ['create'], ['class' => 'btn btn-success']);
            }

            
            
        ?>
    </p>
        <?= GridView::widget([
            'dataProvider'  => $dataProvider,
            'filterModel'   => $searchModel,
            'columns'       => [
                ['class'        => 'yii\grid\SerialColumn'],
                [
                    'label'     =>  'Category (English)',
                    'attribute' =>  'category_name_en',
                ],
                [
                    'label'     =>  'Category (Arabic)',
                    'attribute' =>  'category_name_ar',
                ],
                //'category_name_ar',
                /*[
                    'label'     =>  'Parent Category',
                    'attribute' =>  'parent_category_id',
                    'value'     =>  'parentCategory.category_name_en',
                    'filter'    =>  Html::activeDropDownList($searchModel, 'parent_category_id', ArrayHelper::map($searchModel->getParentCategories(), 'category_id', 'category_name_en'), ['prompt' => 'Select Category'])
                ],*/
                [
                    'label'     =>  'Filter area by vendor',
                    'attribute' =>  'category_vendors_filterable_by_area',
                    'value'     =>  function($model){
                        return ($model->category_vendors_filterable_by_area) ? "Yes" : "No";
                    },
                    'filter'    =>  Html::activeDropDownList($searchModel, 'category_vendors_filterable_by_area', [1 => 'Yes', 0 => 'No'], ['prompt' => 'Select Option']),
                ],
                [
                    'attribute' =>  'status',
                    'value'     =>  function($model){
                        return $model->status == 1 ? "Active" : "Deactive";
                    },
                    'filter'    =>  Html::activeDropDownList($searchModel, 'status', [1 => 'Active', 0 => 'Deactive'], ['prompt' => 'Select Status'])
                ],
                ['class'     =>  'yii\grid\ActionColumn'],
            ],
        ]); 
     ?>
</div>