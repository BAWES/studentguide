<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use backend\models\PushNotification;
use backend\models\PushNotificationHistory;

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
                        'actions' => ['login', 'error', 'forgot_password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'send_notification', 'change_password', 'myaccount'],
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
        $categories         =   \backend\models\Category::find()->count();
        $vendors            =   \backend\models\Vendor::find()->count();
        return $this->render('index', [
            'categoryCount'     =>  $categories,
            'vendorCount'       =>  $vendors,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
            return $this->goHome();

        $this->layout       =   'login';
        $model              =   new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) 
            return $this->redirect(['site/index']);
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
            $model              =   new PushNotificationHistory();
            $model->message_ar  =   $request->post()['PushNotification']['message_ar'];
            $model->message_en  =   $request->post()['PushNotification']['message_en'];
            $model->datetime    =   date('Y-m-d H:i:s');
            $model->save();

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

    /**
    *
    */
    public function actionMyaccount()
    {
        $model              =   User::find()->one();
        $model->scenario    =   "myaccount";
        if($model->load(Yii::$app->request->post()) && $model->save())
            return $this->redirect(['site/myaccount']);
        else
            return $this->render('myaccount', [
                'model' =>  $model,
            ]);
    }

    /**
    * Change the admin password
    */
    public function actionChange_password()
    {
        $model              =   new User();
        $model->scenario    =   "change_password";
        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $user                   =   User::find()->one();
            $user->password_hash    =   Yii::$app->getSecurity()->generatePasswordHash($model->new_password);
            $user->save();

            return $this->redirect(['site/change_password']);
        }
        else
        {
            return $this->render('change_password', [
                'model' =>  $model,
            ]);
        }
    }

    /**
    * Forgot the admin password
    */
    public function actionForgot_password()
    {
        $this->layout       =   'login';

        $model              =   new User();
        $model->scenario    =   "forgot_password";
        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $user                   =   User::find()->one();
            $password               =   Yii::$app->getSecurity()->generateRandomString(6);
            $user->password_hash    =   Yii::$app->getSecurity()->generatePasswordHash($password);
            $user->save();

            $send = Yii::$app->mailer->compose('layouts/html', ['content' => 'Dear Admin, <br> Your password is <b>' . $password . '</b>'])
                ->setFrom('q8studentguide@gmail.com')
                ->setTo($model->email)
                ->setSubject('Forgot Password - Student Guide')
                ->send();

            return $this->redirect(['site/login']);
        }
        else
        {
            return $this->render('forgot_password', [
                'model' =>  $model,
            ]);
        }
    }

        /**
    * Sending push notification to the app installed users
    */
    public function actiontesting()
    {
        $model      =   new PushNotification();
        $request    =   Yii::$app->request;
        if($request->isPost && isset($request->post()['PushNotification']['message_en']) && isset($request->post()['PushNotification']['message_ar']))
        {
            $model              =   new PushNotificationHistory();
            $model->message_ar  =   "testing english";
            $model->message_en  =   "testing arabic";
            $model->datetime    =   date('Y-m-d H:i:s');
            $model->save();

            #Getting the device tokens of the users who choose english language
            $deviceTokens['en'] = \yii\helpers\ArrayHelper::getColumn(PushNotification::find()->select(['device_token'])->where(['language' => 'en'])->asArray()->all(), 'device_token');

            #Getting the device tokens of the users who choose arabic language
            $deviceTokens['ar'] = \yii\helpers\ArrayHelper::getColumn(PushNotification::find()->select(['device_token'])->where(['language' => 'ar'])->asArray()->all(), 'device_token');
            echo "<pre>";
            var_dump($deviceTokens);
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
                    var_dump($response);
                    die;
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
