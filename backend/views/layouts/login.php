<?php
	use yii\bootstrap\ActiveForm;
	use backend\assets\AppAsset;
	use yii\helpers\Html;
	use yii\bootstrap\Nav;
	use yii\bootstrap\NavBar;
	use yii\widgets\Breadcrumbs;

	$this->title = 'Login - POS';
	$this->params['breadcrumbs'][] = $this->title;

	AppAsset::register($this);
?>
<?=	Html::csrfMetaTags() ?> 
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<meta charset="utf-8" />
		<title><?= $this->title; ?></title>
		<link rel="icon" href="<?= $this->theme->getUrl('img/favicon.ico') ?>"/>
		<?php $this->head() ?>
		<!-- END HEAD -->
		
		<!-- BEGIN BODY -->
		<body class="error-body no-top">
			<?php $this->beginBody() ?>
    			<?= $content ?>
			<?php $this->endBody() ?>
		</body>
</html>
<?php $this->endPage() ?>