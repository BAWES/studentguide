<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VendorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vendor Statistics');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider'  =>  $dataProvider,
        'filterModel'   =>  $searchModel,
        'columns'       =>  [
            ['class'            => 'yii\grid\SerialColumn'],
            [
                'attribute' =>  'vendor_id',
                'value'     =>  function($model){
                    $vendor_name = isset($model->vendor[0]->vendor_name_en) ? $model->vendor[0]->vendor_name_en : '';
                    return $vendor_name;
                },
                'filter'    =>  Html::activeDropDownList($searchModel, 'vendor_id', \yii\helpers\ArrayHelper::map($searchModel->getVendors(), 'vendor_id', 'vendor_name_en'), ['prompt' => 'Select Vendor'])
            ],
            'number_of_views',
            [
                'attribute'     =>  'view_date',
                'format'        =>  'date',
                'value'         =>  'view_date',
                'filter'        =>  \yii\jui\DatePicker::widget([
                        'model'         =>  $searchModel,
                        'attribute'     =>  'view_date',
                        'language'      =>  'en',
                        'dateFormat'    =>  'yyyy-MM-dd',
                ]),
            ],
        ],
    ]); ?>
</div>
<?php $this->registerCss('#ui-datepicker-div{z-index:999 !important;};') ?>