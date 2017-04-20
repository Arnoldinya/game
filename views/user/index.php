<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Log;

/* @var $this         yii\web\View */
/* @var $searchModel  app\models\search\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user         app\models\User */

$this->title = 'Истоиря';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_tabs') ?>
<div class="log-index">    

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Текущий баланс <?= $user->balance ?> р.
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model, $key, $index, $grid) {
            if($model->type == Log::TYPE_WIN)
            {
                return ['class' => 'success'];
            }
            else
            {
                return ['class' => 'danger'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'rate',
            'gain',
            'user_position',
            'correct_position',
            [
                'attribute' => 'type',
                'value'     => function ($model) {
                    return $model->type == Log::TYPE_WIN ? 'Выигрыш' : 'Проигрыш';
                },
                'filter'    => Log::getType(),
            ],
            [
                'attribute' => 'created_at',
                'value'     => function ($model) {
                    return date('H:i:s d.m.Y', $model->created_at);
                },
            ]
        ],
    ]); ?>
</div>