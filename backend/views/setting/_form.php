<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'terms_and_conditions')->textarea(['rows' => 6, 'class' => 'ckeditor']) ?>

    <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'offer_image_width')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'offer_image_height')->hiddenInput(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJsFile($this->theme->baseUrl . "/plugins/ckeditor/ckeditor.js"); ?>