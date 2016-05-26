<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VendorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vendor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'vendor_id') ?>

    <?= $form->field($model, 'vendor_logo') ?>

    <?= $form->field($model, 'vendor_name_en') ?>

    <?= $form->field($model, 'vendor_name_ar') ?>

    <?= $form->field($model, 'vendor_description_en') ?>

    <?php // echo $form->field($model, 'vendor_description_ar') ?>

    <?php // echo $form->field($model, 'vendor_phone1') ?>

    <?php // echo $form->field($model, 'vendor_phone2') ?>

    <?php // echo $form->field($model, 'vendor_youtube_video') ?>

    <?php // echo $form->field($model, 'vendor_social_instagram') ?>

    <?php // echo $form->field($model, 'vendor_social_twitter') ?>

    <?php // echo $form->field($model, 'vendor_location') ?>

    <?php // echo $form->field($model, 'vendor_address_text_en') ?>

    <?php // echo $form->field($model, 'vendor_address_text_ar') ?>

    <?php // echo $form->field($model, 'vendor_account_start_date') ?>

    <?php // echo $form->field($model, 'vendor_account_end_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>