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
    <?php if (Yii::$app->setting->get('oiMode')): ?>
        <p>
            If the topic needs to configure subtasks, you can fill in the subtask configuration below. Reference: <?= Html::a('Subtask configuration requirements', ['/wiki/oi']) ?>
        </p>
        <hr>

        <?= Html::beginForm() ?>

        <div class="form-group">
            <?= Html::label(Yii::t('app', 'Subtask'), 'subtaskContent', ['class' => 'sr-only']) ?>

            <?= \app\widgets\codemirror\CodeMirror::widget(['name' => 'subtaskContent', 'value' => $subtaskContent]);  ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= Html::endForm(); ?>
    <?php else: ?>
        <p>The current OJ running mode is not OI mode. To enable subtask editing, you need to enable OI mode on the background settings page. </p>
    <?php endif; ?>
</div>
