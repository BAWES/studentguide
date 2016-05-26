<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Vendor */

$this->title = $model->vendor_name_en;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vendors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->vendor_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->vendor_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'vendor_id',
            'vendor_logo',
            'vendor_name_en',
            'vendor_name_ar',
            'vendor_description_en:ntext',
            'vendor_description_ar:ntext',
            'vendor_phone1',
            'vendor_phone2',
            'vendor_youtube_video',
            'vendor_social_instagram',
            'vendor_social_twitter',
            'vendor_location',
            'vendor_address_text_en',
            'vendor_address_text_ar',
            'vendor_account_start_date',
            'vendor_account_end_date',
        ],
    ]) ?>

</div>