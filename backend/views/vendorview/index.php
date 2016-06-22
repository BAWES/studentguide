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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                    'name'             =>  'VendorViewSearch[view_date]',
                    'id'               =>   'daterange',
                    'pluginOptions'    =>  [ 
                            'locale'    =>  [
                                'separator'   =>  '||',
                            ],
                            'opens'     =>  'right'
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

    $this->registerCss('#ui-datepicker-div{z-index:999 !important;};');
    $this->registerJs('$("#from_date").datepicker({
            "dateFormat"   : "dd-mm-yy", 
            "onSelect" : function(dateText){
                $("#to_date").datepicker("option", "minDate", $(this).datepicker("getDate"));
            }
        }); 
        $("#to_date").datepicker({
            "dateFormat"   : "dd-mm-yy", 
            "onSelect" : function(dateText){
                $("#from_date").datepicker("option", "maxDate", $(this).datepicker("getDate"));
            }
        });');
?>