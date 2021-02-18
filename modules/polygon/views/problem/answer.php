<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;
?>
<div class="problem-solution">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'solution')->widget('app\widgets\ckeditor\CKeditor')->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
