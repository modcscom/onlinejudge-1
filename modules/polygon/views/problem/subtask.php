<?php

use yii\helpers\Html;


$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;

$model->setSamples();
?>
<p>
    If the topic needs to configure subtasks, you can fill in the subtask configuration below. Reference: <?= Html::a('Subtask configuration requirements', ['/wiki/oi']) ?>
</p>

<?php if (Yii::$app->setting->get('oiMode')): ?>
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
    <p>当前 OJ 运行模式不是 OI 模式，要启用子任务编辑，需要在后台设置页面启用 OI 模式。</p>
<?php endif; ?>
