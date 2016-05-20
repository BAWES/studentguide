<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;

    use yii\bootstrap\Alert;
?>
<div class="container">
    <div class="margin text-center" style="margin-top: 50px;  margin-bottom: 25px;">
        <img src="<?= $this->theme->getUrl('img/logo.png') ?>" class="logo" alt="" data-src="" data-src-retina="" width="10%" height=""/>
    </div>
    <div class="row login-container">
        <div class="col-md-5 col-md-offset-4" style="padding: 1% 8% 3% 8%;  background: white;  width: 40%; border-radius:20px; margin-left:30%;">
            <h2><center>Sign In</center></h2>  
            <br>
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'username')->textInput(['maxlength' => 255, 'autocomplete' => 'off'])?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <div class="form-inline">
                    <?= Html::submitButton('Login', ['class' => 'col-md-5 btn btn-success pull-left']) ?>
                </div>
            <?php ActiveForm::end(); ?> 
            <div style="clear:both;"></div>
            <br><br>
            <?php
                if($flash = Yii::$app->session->getFlash('success'))
                    echo Alert::widget(['options' => ['class' => 'alert-success'], 'body' => $flash,'closeButton'=>['label'=>'']]);
                if($flash = Yii::$app->session->getFlash('danger'))
                    echo Alert::widget(['options' => ['class' => 'alert-danger'], 'body' => $flash,'closeButton'=>['label'=>'']]);
            ?>
        </div>   
    </div>
</div>