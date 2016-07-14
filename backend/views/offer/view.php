<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Offer */

$this->title = $model->name_en;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Offers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-default']); ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name_en',
            'name_ar',
            'url',
            [
                'attribute' =>  'image',
                'value'     =>  ($model->image) ? Html::img($model->image, ['id' => 'image']) : '',
                'format'    =>  'raw',
            ],
            'start_date',
            'end_date',
            [
                'attribute' =>  'status',
                'value'     =>  ($model->status == 1) ? 'Active' : 'Deactive',
                'format'    =>  'raw',
            ],
            'sort_order',
            [
                'attribute' =>  'created_datetime',
                'format'    =>  'datetime',
            ],
        ],
    ]) ?>

</div>
<?php $this->registerCss("#image{width: 30%;}"); ?>