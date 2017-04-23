<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Log;
use yii\grid\GridView;

/* @var $this         yii\web\View */
/* @var $searchModel  app\models\search\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1>
    	<?= Html::encode($this->title) ?>
    </h1>

	<?= GridView::widget([
	    'dataProvider' => $dataProvider,
	    'columns' => [
	        ['class' => 'yii\grid\SerialColumn'],

	        [
	        	'attribute' => 'user_id',
	        	'value'     => function ($model) {
	        		return $model->user->name;
	        	},
	        ],	        
	        'cnt',
	        'value',
	    ],
	]); ?>
</div>
