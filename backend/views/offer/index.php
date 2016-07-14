<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OfferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Offers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Offer'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class'            => 'yii\grid\SerialColumn'],
            'name_en',
            'name_ar',
            [
                'attribute'     =>  'start_date',
                'filter'        =>  \yii\jui\DatePicker::widget([
                    'model'         =>  $searchModel,
                    'attribute'     =>  'start_date',
                    'language'      =>  'en',
                    'dateFormat'    =>  'yyyy-MM-dd',
                ]),
                'format'        =>  'html',
            ],
            [
                'attribute'     =>  'end_date',
                'filter'        =>  \yii\jui\DatePicker::widget([
                    'model'         =>  $searchModel,
                    'attribute'     =>  'end_date',
                    'language'      =>  'en',
                    'dateFormat'    =>  'yyyy-MM-dd',
                ]),
                'format'        =>  'html',
            ],
            [
                'attribute'     =>  'status',
                'value'         =>  function($model){
                    return ($model->status == 1) ? "Active" : "Deactive";
                },
                'filter'        =>  Html::activeDropDownList($searchModel, 'status', [1 => 'Active', 0 => 'Deactive'], ['prompt' => 'Select Status'])
            ],
            [
                'class'         =>  'yii\grid\ActionColumn',
                'template'      =>  '{update}{view}{delete}',
            ],
        ],
    ]); ?>
</div>
<?php $this->registerCss('#ui-datepicker-div{z-index:999 !important;};') ?>