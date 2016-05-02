<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\User;
use app\models\SignUpForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest) { $this->redirect(['book/']);}
        return $this->render('index');
    }

    public function actionRegister()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignUpForm();

        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $user = new User();
            $user->login = $model->login;
            $user->password_hash = $model->password;
            if($user->save()) {
                Yii::$app->session->setFlash('success', 'Регистрация прошла успешно');
                return $this->redirect(['login']);
            }

        } else {
            return $this->render('register', [
                'model' => $model,
            ]);
        }
    }


    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/book');
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}
