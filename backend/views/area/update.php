<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Area */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Area',
]) . $model->area_name_en;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Areas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->area_name_en, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="area-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>