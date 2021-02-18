<?php

use yii\helpers\Html;

$this->title = Html::encode($model->title);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$this->params['model'] = $model;
?>
<div class="problem-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
