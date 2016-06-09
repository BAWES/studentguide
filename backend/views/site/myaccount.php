<?php 
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    $this->title    =   'My Account';
?>
<div class="change-password-form">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'username')->label('Current Password') ?>
        <?= $form->field($model, 'email') ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>