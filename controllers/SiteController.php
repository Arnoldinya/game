<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\forms\LoginForm;
use app\models\forms\LogForm;
use app\models\forms\UserForm;
use app\models\User;
use app\models\Log;

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
                        'actions' => ['logout', 'game', 'error', 'stat', 'index', 'registry'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'index', 'error', 'stat', 'registry'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Игра
     *
     * @return string
     */
    public function actionGame()
    {
        $user = User::findOne(Yii::$app->user->id);

        $postiton = rand(1, 3);

        $logForm = new LogForm([
            'correct_position' => $postiton,
            'user_id'          => $user->id,
        ]);

        if ($logForm->load(Yii::$app->request->post()))
        {
            $logForm->save();
            $user = User::findOne(Yii::$app->user->id);
        }

        return $this->render('game', [
            'logForm'  => $logForm,
            'user'     => $user,
            'postiton' => $postiton,
        ]);
    }

    /**
     * Статистика
     *
     * @return string
     */
    public function actionStat()
    {
        $query = Log::find()
            ->select([
                'user_id',
                'sum(gain) as s_gain',
                'sum(type) as s_type',
            ])
            ->groupBy('user_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => [
                'attributes' => [
                    's_type',
                    's_gain',
                ],
                'defaultOrder' => [
                    's_type'  => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('stat', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Регистрация
     *
     * @return string
     */
    public function actionRegistry()
    {
        $userForm = new UserForm();

        if ($userForm->load(Yii::$app->request->post()) && $userForm->save())
        {
            Yii::$app->user->logout();
            Yii::$app->user->login($userForm->model, 0);

            return $this->redirect(['game']);
        }

        return $this->render('registry', [
            'userForm' => $userForm,
        ]);
    }
}
