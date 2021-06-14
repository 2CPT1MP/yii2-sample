<?php

/* @var $this yii\web\View */
/* @var $title string */
/* @var $message string */

use yii\helpers\Html;

?>
<div class="site-error">
    <h1><?= Html::encode($title) ?></h1>
    <div class="alert alert-success">
        <?= nl2br(Html::encode($message)) ?>
    </div>
</div>
