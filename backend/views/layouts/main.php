<?php
    use backend\assets\AppAsset;
    use yii\helpers\Html;
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
    use yii\widgets\Breadcrumbs;
    use yii\bootstrap\Alert;

    AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?= $this->theme->getUrl('img/favicon.ico') ?>"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
            <?php $this->beginContent('@app/views/layouts/header.php'); ?>
            <?php $this->endContent(); ?>
            <div class="page-container row-fluid">
                <?php $this->beginContent('@app/views/layouts/sidebar.php'); ?>
                <?php $this->endContent(); ?>
                <div class="page-content"> 
                    <div class="content">
                        <?php
                            if($flash = Yii::$app->session->getFlash('success'))
                                echo Alert::widget(['options' => ['class' => 'alert-success'], 'body' => $flash,'closeButton'=>['label'=>'']]);
                            if($flash = Yii::$app->session->getFlash('danger'))
                                echo Alert::widget(['options' => ['class' => 'alert-danger'], 'body' => $flash,'closeButton'=>['label'=>'']]);
                        ?>
                        <?= 
                            Breadcrumbs::widget([
                                'homeLink' => [ 'label' => 'Dashboard','url' =>['default/index'],],
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                'activeItemTemplate'=>'<li class=\"active\"><b>{link}</b></li>'
                            ]) 
                        ?>
                        <div class="page-title"> <i class="icon-custom-left"></i>
                            <h3><span class="semi-bold"><?= Html::encode($this->title) ?></span></h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="grid simple">
                                    <div class="grid-body no-border"> <br>
                                        <div class="row">
                                            <?= $content ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="status_notification failure"></div>
                <!-- END PAGE CONTAINER -->
                <?php $this->beginContent('@app/views/layouts/footer.php'); ?>
                <?php $this->endContent(); ?>
                
                <?php $this->registerJs("jQuery('.alert-success, .alert-danger').fadeIn().delay(4000).fadeOut(function(){jQuery(this).remove();}); $('.dropdown-toggle').dropdown();"); ?>


        <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
