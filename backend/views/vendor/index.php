<?php

use yii\helpers\Html;
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
        <?= Html::a(Yii::t('app', 'Create Vendor'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'vendor_id',
            //'vendor_logo',
            [
                'attribute' =>  'vendor_name_en',
                'label'     =>  'Vendor Name (English)',
            ],
            [
                'attribute' =>  'vendor_name_ar',
                'label'     =>  'Vendor Name (Arabic)',
            ],
            //'vendor_description_en:ntext',
            // 'vendor_description_ar:ntext',
            // 'vendor_phone1',
            // 'vendor_phone2',
            // 'vendor_youtube_video',
            // 'vendor_social_instagram',
            // 'vendor_social_twitter',
            // 'vendor_location',
            // 'vendor_address_text_en',
            // 'vendor_address_text_ar',
            [
                'attribute' =>  'vendor_account_start_date',
                'label'     =>  'Start Date',
            ],
            [
                'attribute' =>  'vendor_account_end_date',
                'label'     =>  'Renewal Date',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>