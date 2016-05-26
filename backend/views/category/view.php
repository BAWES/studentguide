<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */

$this->title = $model->category_name_en;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->category_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->category_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' =>  'parent_category_id',
                'value'     =>  ($model->parent_category_id) ? $model->parentCategory->category_name_en : '',
            ],
            [
                'attribute' =>  'category_name_en',
                'label'     =>  'Category Name (English)'
            ],
            [
                'attribute' =>  'category_name_ar',
                'label'     =>  'Category Name (Arabic)'
            ],
            [
                'attribute' =>  'category_vendors_filterable_by_area',
                'value'     =>  ($model->category_vendors_filterable_by_area == 1) ? "Yes" : "No",
            ],
            [
                'attribute' =>  'category_created_datetime',
                'format'    =>  'datetime',
            ],
            [
                'attribute' =>  'category_updated_datetime',
                'format'    =>  'datetime',
            ],
        ],
    ]) ?>

</div>