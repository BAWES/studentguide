<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Offer */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Offer',
]) . $model->name_en;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Offers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_en, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="area-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>