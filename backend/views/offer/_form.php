<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Offer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="area-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_ar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*'])->hint('Image size: ' . $offerImageSetting['offer_image_width'] . ' * ' . $offerImageSetting['offer_image_height']) ?>

    <?php 
        if(!$model->isNewRecord && $model->image)
            echo Html::img($model->image, ['id' => 'image']) ;
    ?>

    <?= $form->field($model, 'start_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'end_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([1 => 'Active', 0 => 'Deactive'], ['prompt' => 'Select Status']) ?>

    <?= $form->field($model, 'sort_order')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
	$this->registerCss('#image{width: 30%;}div#ui-datepicker-div{z-index:9999 !important;}');
	$this->registerJs('// get the form id and set the event
	    $("#w0").on("afterValidate", function(e) {
	        // return false to prevent submission
	        if(($(".has-error").length != 0)){
	            $("#fade").remove();
	            $(".processing_image").hide();
	            return true;
	        }
	        return false;
	    });
		$("#offer-start_date").datepicker({
            "dateFormat"   : "yy-mm-dd", 
            //"minDate"      : 0,
            "onSelect" : function(dateText){
                $("#offer-end_date").datepicker("option", "minDate", $(this).datepicker("getDate"));
            }
        }); 
        $("#offer-end_date").datepicker({
            "dateFormat"   : "yy-mm-dd", 
            //"minDate"      : 0,
            "onSelect" : function(dateText){
                $("#offer-start_date").datepicker("option", "maxDate", $(this).datepicker("getDate"));
            }
        });
	');
?>
