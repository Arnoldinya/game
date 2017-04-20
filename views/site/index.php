<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">

        <p>
            <a class="btn btn-lg btn-success" href="<?= Url::to(['site/registry']) ?>">
                Регистрация
            </a>
        </p>

        <p>
            <a class="btn btn-lg btn-success" href="<?= Url::to(['site/game']) ?>">
                Играть
            </a>
        </p>
    </div>
</div>
