<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Vendor */

$this->title = Yii::t('app', 'Create Vendor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vendors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-create">

    <?= $this->render('_form', [
        'model' 		=>	$model,
        'categories'	=>	$categories,
        'areas'			=>	$areas,
        'categoryID'    =>  $categoryID,
    ]) ?>

</div>