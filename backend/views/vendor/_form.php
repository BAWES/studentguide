<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Vendor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vendor-form">

    <?php $form = ActiveForm::begin(['options'  =>  ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'vendor_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_name_ar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_description_en')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'vendor_description_ar')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'vendor_category')->dropDownList(ArrayHelper::map($categories, 'category_id', 'category_name_en'), ['class' => 'selectpicker', 'title' => 'Select Category', 'multiple' => true, "data-selected-text-format" => "count"]) ?>

    <?= $form->field($model, 'vendor_area')->dropDownList(ArrayHelper::map($areas, 'id', 'area_name_en'), ['class' => 'selectpicker', 'title' => 'Select Area', 'multiple' => true, "data-selected-text-format" => "count"]) ?>

    <?= $form->field($model, 'vendor_logo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_phone1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_phone2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_youtube_video')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_social_instagram')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_social_twitter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_address_text_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_address_text_ar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_account_start_date')->textInput(['class' => 'datepicker startDate']) ?>

    <?= $form->field($model, 'vendor_account_end_date')->textInput(['class' => 'datepicker endDate']) ?>

    <?= $form->field($model, 'vendor_gallery[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
    $this->registerCss("#ui-datepicker-div { z-index: 999999 !important;}");
    $this->registerCssFile($this->theme->baseUrl . "/plugins/bootstrap-select-1.10.0/css/bootstrap-select.min.css");
    $this->registerJsFile($this->theme->baseUrl . "/plugins/bootstrap-select-1.10.0/js/bootstrap-select.min.js", ['depends' => \yii\web\JqueryAsset::className()]);
    $this->registerJs("$('.datepicker').datepicker({minDate: 0, dateFormat: 'dd-mm-yy'});$(document).on('change', '.startDate', function(){
        $('.endDate').datepicker(\"option\", \"minDate\", $(this).datepicker(\"getDate\"));
        });
        $(document).on('change', '.endDate', function(){
            $('.startDate').datepicker(\"option\", \"maxDate\", $(this).datepicker(\"getDate\"));
        });
    ");
?>