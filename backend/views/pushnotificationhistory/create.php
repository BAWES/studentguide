<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PushNotificationHistory */

$this->title = Yii::t('app', 'Create Push Notification History');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Push Notification Histories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="push-notification-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
