<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title 					=	Yii::t('app', 'Push Notification History');
$this->params['breadcrumbs'][]	=	$this->title;
?>

<div id="history">
	<?= GridView::widget([
		'dataProvider'	=>	$dataProvider,
		'filterModel'	=>	$searchModel,
		'columns'		=>	[
			['class'		=>	'yii\grid\SerialColumn'],
			'message_en',
			'message_ar',
			[
				'attribute'	=>	'datetime',
				'format'	=>	'datetime',
			]
		]
	])	?>
</div>