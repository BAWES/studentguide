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

    <!-- $form->field($model, 'parent_category_id')->hiddenInput(['value' => $parentCategoryId])->label(false) ?>-->
    <?php if($parentCategoryId) { 
        $model->parent_category_id = $category['category_id'];
        echo $form->field($model, 'parent_category_id')->dropDownList([$category['category_id'] => $category['category_name_en']])->label('Parent Category');
     } ?>

    <?php
        if($model->isNewRecord)
            $model->category_vendors_filterable_by_area = 0;
    ?>
    
    <?= $form->field($model, 'category_vendors_filterable_by_area')->radioList([1 => 'Yes', 0 => 'No']) ?>

    <?php
        if($model->isNewRecord)
            $model->status = 1;
    ?>
    
    <?= $form->field($model, 'status')->radioList([1 => 'Active', 0 => 'Deactive']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['category/index', 'id' => $parentCategoryId], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>