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

class GameController extends Controller
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
                        'actions' => ['index', 'stat'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['stat'],
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
     * Игра
     *
     * @return string
     */
    public function actionIndex()
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

        return $this->render('index', [
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
}
