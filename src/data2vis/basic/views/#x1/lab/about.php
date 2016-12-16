<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
//$this->params['breadcrumbs'][] = $this->title;  ??提示不正确：home/About
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        关于 Lab...
    </p>

    <code><?= __FILE__ ?></code>
</div>
