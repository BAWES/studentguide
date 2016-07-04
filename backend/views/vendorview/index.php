<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\VendorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vendor Statistics');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-index">

    <?= GridView::widget([
        'dataProvider'  =>  $dataProvider,
        'filterModel'   =>  $searchModel,
        'columns'       =>  [
            ['class'            => 'yii\grid\SerialColumn'],
            [
                //'attribute' =>  'vendor_id',
                'attribute' =>  'vendor_name_en',
                'value'     =>  function($model){
                    $vendor_name = isset($model->vendor[0]->vendor_name_en) ? $model->vendor[0]->vendor_name_en : '';
                    return $vendor_name;
                },
                //'filter'    =>  Html::activeDropDownList($searchModel, 'vendor_id', \yii\helpers\ArrayHelper::map($searchModel->getVendors(), 'vendor_id', 'vendor_name_en'), ['prompt' => 'Select Vendor'])
            ],
            [
                'attribute' =>  'vendor_name_ar',
                'value'     =>  function($model){
                    $vendor_name = isset($model->vendor[0]->vendor_name_ar) ? $model->vendor[0]->vendor_name_ar : '';
                    return $vendor_name;
                },
                //'filter'    =>  Html::textInput($searchModel, 'vendor_name_ar')
            ],
            [
                'attribute'     =>  'view_date',
                'format'        =>  'date',
                'value'         =>  'view_date',
                'filter'        =>  DateRangePicker::widget([
                    'name'             =>   'VendorViewSearch[view_date]',
                    'id'               =>   'daterange',
                    'value'            =>   isset(Yii::$app->request->queryParams['VendorViewSearch']['view_date']) ? Yii::$app->request->queryParams['VendorViewSearch']['view_date'] : '',
                    'pluginOptions'    =>   [ 
                            'locale'    =>      [
                                'separator'         =>  ' - ',
                                'format'            =>  'Y-MM-DD',
                            ],
                            'opens'     =>  'left'
                    ] 
                ]) . '</div>',
                /*'content'=>function($data){
                           return Yii::$app->formatter->asDatetime($data['created_at'], "php:d-M-Y");
                   }*/
            ],
            'number_of_views',
            
        ],
    ]); ?>
</div>
<?php 

    $this->registerCss('#ui-datepicker-div{z-index:999 !important;}input.input-mini{padding: 0 6px 0 28px !important;');
?>