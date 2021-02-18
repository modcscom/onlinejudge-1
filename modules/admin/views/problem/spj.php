<?php

use yii\helpers\Html;
use app\models\Solution;
use yii\widgets\ActiveForm;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;
?>
<div class="solutions-view">
    <h1>
        <?= Html::encode($model->title) ?>
    </h1>
    <?php if ($model->spj): ?>
        <p>
            If the subject requires special judge, please fill in the special judge procedure below. Reference: <?= Html::a('How to write special judge procedures?', ['/wiki/spj']) ?>
        </p>
        <hr>

        <?= Html::beginForm() ?>

        <div class="form-group">
            <?= Html::textInput('spjLang', 'C、C++', ['disabled' => true, 'class' => 'form-control']); ?>
            <p class="hint-block">Currently only supports C\C++. </p>
        </div>

        <div class="form-group">
            <?= Html::label(Yii::t('app', 'Spj'), 'spj', ['class' => 'sr-only']) ?>

            <?= \app\widgets\codemirror\CodeMirror::widget(['name' => 'spjContent', 'value' => $spjContent]);  ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= Html::endForm(); ?>
    <?php else: ?>
        <p>The current question is not an SPJ judgement question. If you need to enable the SPJ judgement question, please change Special Judge to Yes.</p>
    <?php endif; ?>
</div>