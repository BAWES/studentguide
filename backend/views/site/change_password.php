<?php 
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    $this->title    =   'Change Password';
?>
<div class="change-password-form">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'current_password')->label('Current Password') ?>
        <?= $form->field($model, 'new_password') ?>
        <?= $form->field($model, 'confirm_password') ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Change Password'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>