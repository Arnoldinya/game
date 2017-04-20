<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this    yii\web\View */
/* @var $user    app\models\User */
/* @var $payForm app\models\forms\payForm */
/* @var $form    yii\widgets\ActiveForm */

$this->title = 'Пополнить баланс';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_tabs') ?>
<div class="pay-index">
    
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Текущий баланс <?= $user->balance ?> р.
    </p>
</div>

<div class="pay-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($payForm, 'value')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Пополнить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>