<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Offer */

$this->title = Yii::t('app', 'Create Offer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Offers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-create">

    <?= $this->render('_form', [
        'model' 			=>	$model,
        'offerImageSetting'	=>	$offerImageSetting,
    ]) ?>

</div>