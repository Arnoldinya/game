<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\User;
use app\models\Log;
use app\models\search\LogSearch;
use app\models\search\PaySearch;
use app\models\forms\PayForm;

class UserController extends Controller
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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Log models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $user = User::findOne(Yii::$app->user->id);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'user'         => $user,
        ]);
    }

    /**
     * Lists all Pay models.
     * @return mixed
     */
    public function actionPay()
    {
        $searchModel = new PaySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $user = User::findOne(Yii::$app->user->id);

        return $this->render('pay', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'user'         => $user,
        ]);
    }

    /**
     * Creates a new Pay model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBalance()
    {
        $user = User::findOne(Yii::$app->user->id);
        $payForm = new PayForm([
            'user_id' => $user->id,
        ]);        

        if ($payForm->load(Yii::$app->request->post()) && $payForm->save()) {
            return $this->redirect(['pay']);
        } else {
            return $this->render('balance', [
                'payForm' => $payForm,
                'user'    => $user,
            ]);
        }
    }
}
