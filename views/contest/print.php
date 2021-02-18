<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$this->title = $model->title;
$this->params['model'] = $model;

?>
<div class="print-source-index" style="margin-top: 20px">

    <div class="well">
        Nếu cần in bài nộp để kiểm tra thì có thể gửi bài nộp tại đây, chúng tôi sẽ gửi bản in cho bạn.
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->id, ['/print/view', 'id' => $model->id], ['target' => '_blank']);
                },
                'format' => 'raw'
            ],
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'print'
            ],
        ],
    ]); ?>

    <hr>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($newContestPrint, 'source')->widget('app\widgets\codemirror\CodeMirror'); ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>