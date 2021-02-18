<?php

use yii\helpers\Html;

$this->title = $model->name;
?>
<div class="group-update">

    <h1><?= Html::a(Html::encode($this->title), ['/group/view', 'id' => $model->id]) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <hr>

    <?= Html::a('Delete group', ['/group/delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data-confirm' => 'This action will delete all match information and team submissions and cannot be recovered. Are you sure you want to delete? ',
        'data-method' => 'post',
    ]) ?>

</div>
