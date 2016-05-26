<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_name_en')->textInput(['maxlength' => true])->label('Category Name (English)') ?>

    <?= $form->field($model, 'category_name_ar')->textInput(['maxlength' => true])->label('Category Name (Arabic)') ?>

    <?= $form->field($model, 'parent_category_id')->dropDownList(ArrayHelper::map($model->getCategoryList(), 'category_id', 'category_name_en'), ['prompt' => 'Select Category'])->label('Parent Category') ?>

    <?php
        if($model->isNewRecord)
                $model->category_vendors_filterable_by_area = 0;
    ?>
    
    <?= $form->field($model, 'category_vendors_filterable_by_area')->radioList([1 => 'Yes', 0 => 'No']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['category/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>