<?php

use app\models\Article;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/**
 * @var $model Article
 */
?>

<div>
    <h3>
        <?= Html::encode($model->title); ?>
    </h3>
    <div>
        <?= StringHelper::truncateWords(Html::encode($model->body), 40); ?>
    </div>
    <hr/>
</div>
