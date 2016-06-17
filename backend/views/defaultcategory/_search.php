<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'parent_category_id') ?>

    <?= $form->field($model, 'category_name_en') ?>

    <?= $form->field($model, 'category_name_ar') ?>

    <?= $form->field($model, 'category_vendors_filterable_by_area') ?>

    <?php // echo $form->field($model, 'category_created_datetime') ?>

    <?php // echo $form->field($model, 'category_updated_datetime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>