<?php

use yii\helpers\Url;

/* @var $this         yii\web\View */
?>
<ul class="nav nav-tabs">
	<li>
		<a href="<?= Url::to(['user/index']) ?>" class="<?= Yii::$app->controller->action->id == 'index' ? 'active' : '' ?>">
			История
		</a>
	</li>
	<li>
		<a href="<?= Url::to(['user/pay']) ?>" class="<?= Yii::$app->controller->action->id == 'pay' ? 'active' : '' ?>">
			Платежи
		</a>
	</li>
	<li>
		<a href="<?= Url::to(['user/balance']) ?>" class="<?= Yii::$app->controller->action->id == 'balance' ? 'active' : '' ?>">
			Пополнить баланс
		</a>
	</li>
</ul>