<?php

    namespace backend\assets;
    use yii\web\AssetBundle;

    /**
     * Main backend application asset bundle.
     */
    class AppAsset extends AssetBundle
    {
        public $sourcePath  = '@webroot/themes/default';
        public $css         = [
            'plugins/pace/pace-theme-flash.css',
            'plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css',
            'plugins/boostrapv3/css/bootstrap-theme.min.css',
            'plugins/font-awesome/css/font-awesome.css',
            'css/animate.min.css',
            'plugins/jquery-scrollbar/jquery.scrollbar.css',
            'css/style.css',
            'css/responsive.css',
            'css/custom-icon-set.css',
        ];
        public $js          = [
            'js/core.js',
            'plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js',
            'plugins/boostrapv3/js/bootstrap.min.js',
            'plugins/breakpoints.js',
            'plugins/jquery-unveil/jquery.unveil.min.js',
            'plugins/jquery-scrollbar/jquery.scrollbar.min.js',
            'plugins/jquery-numberAnimate/jquery.animateNumbers.js',
        ];
        public $depends     = [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ];
    }