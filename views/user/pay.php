<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this         yii\web\View */
/* @var $searchModel  app\models\search\PaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user         app\models\User */

$this->title = 'Платежи';
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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'value',
            [
                'attribute' => 'created_at',
                'value'     => function ($model) {
                    return date('H:i:s d.m.Y', $model->created_at);
                },
            ]
        ],
    ]); ?>
</div>