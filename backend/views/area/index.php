<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Areas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Area'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class'            => 'yii\grid\SerialColumn'],
            'area_name_en',
            'area_name_ar',
            [
                'class'         =>  'yii\grid\ActionColumn',
                'template'      =>  '{update}{view}{delete}',
            ],
        ],
    ]); ?>
</div>