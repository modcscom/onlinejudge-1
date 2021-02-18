<?php

use yii\helpers\Html;

$this->title = 'Import Problem From Polygon System';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="problem-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <?= Html::beginForm() ?>
    <div class="form-group">
        <p>Import problem </p>
        <div class="input-group">
            <span class="input-group-addon" id="polygon_problem_id"><?= Yii::t('app', 'Polygon Problem ID') ?></span>
            <?= Html::textInput('polygon_problem_id', '', ['class' => 'form-control']) ?>
        </div>
        <p class="help-block">Please provide the location <?= Html::a(Yii::t('app', 'Polygon System'), ['/polygon/problem']) ?> question ID</p>
    </div>

    <div class="form-group">
        <p>Import multi problems </p>
        <div class="input-group">
            <span class="input-group-addon">From</span>
            <?= Html::textInput('polygon_problem_id_from', '', ['class' => 'form-control']) ?>
            <span class="input-group-addon">to</span>
            <?= Html::textInput('polygon_problem_id_to', '', ['class' => 'form-control']) ?>
        </div>
        <p class="help-block">Please provide the location <?= Html::a(Yii::t('app', 'Polygon System'), ['/polygon/problem']) ?> range of the problem ID</p>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success']) ?>
    </div>
    <?= Html::endForm() ?>
</div>
