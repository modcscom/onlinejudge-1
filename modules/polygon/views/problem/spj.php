<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Solution;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;

$model->setSamples();
?>

<?php if ($model->spj): ?>
    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'spj_lang')->textInput([
        'maxlength' => true, 'value' => 'C、C++', 'disabled' => true
    ]) ?>

    <?= $form->field($model, 'spj_source')->widget('app\widgets\codemirror\CodeMirror'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php else: ?>
    <p>The current problem is not an SPJ judgement question. If you need to enable the SPJ judgement question, please  change Special Judge to Yes.</p>
<?php endif; ?>
