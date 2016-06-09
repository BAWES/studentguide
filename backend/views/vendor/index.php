<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VendorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vendors');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
            echo Html::a(Yii::t('app', 'Create Vendor'), ['create', 'id' => $category['category_id']], ['class' => 'btn btn-success']);
            echo Html::a('Back', ['category/index', 'id' => $category['parent_category_id']], ['class' => 'btn btn-default']);
        ?>
    </p>
    <?= GridView::widget([
        'dataProvider'  =>  $dataProvider,
        'filterModel'   =>  $searchModel,
        'columns'       =>  [
            ['class'            => 'yii\grid\SerialColumn'],

            //'vendor_id',
            //'vendor_logo',
            [
                'attribute'     =>  'vendor_name_en',
                'label'         =>  'Vendor Name (English)',
            ],
            [
                'attribute'     =>  'vendor_name_ar',
                'label'         =>  'Vendor Name (Arabic)',
            ],

            [
                'attribute'     =>  'vendor_account_start_date',
                'label'         =>  'Start Date',
                'filter'        =>  \yii\jui\DatePicker::widget([
                        'model'         =>  $searchModel,
                        'attribute'     =>  'vendor_account_start_date',
                        'language'      =>  'en',
                        'dateFormat'    =>  'yyyy-MM-dd',
                ]),
                'format'        =>  'html',
            ],
            [
                'attribute'     =>  'vendor_account_end_date',
                'label'         =>  'Renewal Date',
                'filter'        =>  \yii\jui\DatePicker::widget([
                        'model'         =>  $searchModel,
                        'attribute'     =>  'vendor_account_end_date',
                        'language'      =>  'en',
                        'dateFormat'    =>  'yyyy-MM-dd',
                ]),
                'format'        =>  'html',
            ],
            [
                'class'         => 'yii\grid\ActionColumn',
                'template'      =>  '{view}{update}{delete}',
                'urlCreator'    =>  function($action, $model, $key, $index){
                    $params = ['id' => $model->vendor_id];
                    if($action == 'view')
                        return Url::to(['view', 'id' => $model->vendor_id, 'category' => $model::$category_id]);
                    else if($action == 'update')
                        return Url::to(['update', 'id' => $model->vendor_id, 'categoryID' => $model::$category_id]);
                    else
                        return Url::to(['delete', 'id' => $model->vendor_id, 'category' => $model::$category_id]);
                }
            ],
        ],
    ]); ?>
</div>
<?php $this->registerCss('#ui-datepicker-div{z-index:999 !important;};') ?>