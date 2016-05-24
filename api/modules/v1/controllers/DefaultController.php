<?php

namespace api\modules\v1\controllers;

use yii\web\Controller;
use Yii;

/**
 * Default controller for the `v1` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	Yii::$app->language 	=	"en";
    	echo Yii::t("api", "testing");
    	//die("ssss");
        //return $this->render('index');
    }

}