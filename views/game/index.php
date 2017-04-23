<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\models\Log;

/* @var $this    yii\web\View */
/* @var $logForm app\models\forms\LogForm */
/* @var $user    app\models\User */
/* @var $form    yii\widgets\ActiveForm */

$this->title = 'Игра';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>
	<div class="site-about">
	    <h1>
	    	<?= Html::encode($this->title) ?>
	    </h1>

	   	<p>
	   		Выш баланс <?= $user->balance ?> р.
	   	</p>
	   	<p>
	   		<a class="btn btn-sm btn-info" href="<?= Url::to(['user/balance']) ?>">
	            Пополнить баланс
	        </a>
	   	</p>
	</div>

	<div class="log-form">

	    <?php $form = ActiveForm::begin([
	    	'options' => [
	    		'data-pjax' => true,
	    	]
	    ]); ?>

	    <?= $form->field($logForm, 'rate')->textInput() ?>

	    <?= $form->field($logForm, 'user_position')->dropDownList([
	    	1 => 1,
	    	2 => 2,
	    	3 => 3,
	    ]) ?>

	    <div class="form-group">
	        <?= Html::submitButton('Узнать результат', ['class' => 'btn btn-success']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

	<?php if (!$logForm->isNewRecord): ?>
	<div class="alert <?= $logForm->type== Log::TYPE_WIN ? 'bg-success' : 'bg-danger' ?>">
		<?= $logForm->type== Log::TYPE_WIN ? 'Вы выиграли' : 'Вы проиграли' ?>
	</div>
	<?php endif ?>
<?php Pjax::end(); ?>
