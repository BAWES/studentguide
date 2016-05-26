<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Vendor */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Vendor',
]) . $model->vendor_name_en;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vendors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vendor_id, 'url' => ['view', 'id' => $model->vendor_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vendor-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>