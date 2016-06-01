<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\PushNotification;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'send_notification'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            /*'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $categories = \backend\models\Category::find()->count();
        $vendors    = \backend\models\Vendor::find()->count();
        return $this->render('index', [
            'categoryCount' =>  $categories,
            'vendorCount'   =>  $vendors,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
            return $this->goHome();

        $this->layout = 'login';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) 
            return $this->goBack();
        else 
            return $this->render('login', [
                'model' => $model,
            ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
    * Sending push notification to the app installed users
    */
    public function actionSend_notification()
    {
        $model      =   new PushNotification();
        $request    =   Yii::$app->request;
        if($request->isPost && isset($request->post()['PushNotification']['message_en']) && isset($request->post()['PushNotification']['message_ar']))
        {
            #Getting the device tokens of the users who choose english language
            $deviceTokens['en'] = \yii\helpers\ArrayHelper::getColumn(PushNotification::find()->select(['device_token'])->where(['language' => 'en'])->asArray()->all(), 'device_token');

            #Getting the device tokens of the users who choose arabic language
            $deviceTokens['ar'] = \yii\helpers\ArrayHelper::getColumn(PushNotification::find()->select(['device_token'])->where(['language' => 'ar'])->asArray()->all(), 'device_token');
            
            foreach($deviceTokens AS $key => $tokens)
            {
                if($tokens)
                {
                    if($key == "en")
                        $content = ['en' => $request->post()['PushNotification']['message_en']];
                    else
                        $content = ['en' => $request->post()['PushNotification']['message_ar']];

                    $fields = array(
                      'app_id'              => Yii::$app->params['oneSignalAppId'],
                      'include_player_ids'  => $tokens,
                      'contents'            => $content
                    );
                    
                    $fields = json_encode($fields);
                    
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic ' . Yii::$app->params['oneSignalRestKey']));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_HEADER, FALSE);
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                    $response = curl_exec($ch);
                    curl_close($ch);
                }
            }
            $this->redirect(['site/send_notification']);
        }
        else
        {
            return $this->render('notification', [
                'model' =>  $model
            ]);
        }
    }
}
