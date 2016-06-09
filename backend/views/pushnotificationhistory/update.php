<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PushNotificationHistory */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Push Notification History',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Push Notification Histories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="push-notification-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
