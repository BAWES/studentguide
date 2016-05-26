<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Vendor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vendor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vendor_logo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_name_ar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_description_en')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'vendor_description_ar')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'vendor_category')->dropDownList([1 => 1], ['class' => 'selectpicker2', 'title' => 'select']) ?>

    <?= $form->field($model, 'vendor_phone1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_phone2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_youtube_video')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_social_instagram')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_social_twitter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_address_text_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_address_text_ar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_account_start_date')->textInput() ?>

    <?= $form->field($model, 'vendor_account_end_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
    $this->registerJsFile($this->theme->baseUrl . "/plugins/bootstrap-select-1.10.0/js/bootstrap-select.min.js", ['depends' => \yii\web\JqueryAsset::className()]);
    $this->registerJs("$('.selectpicker2').selectpicker();");
?>