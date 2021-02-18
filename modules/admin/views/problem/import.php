<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Import Problem';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$maxFileSize = min(ini_get("upload_max_filesize"),ini_get("post_max_size"));
?>
<div class="problem-import">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Currently, only topics exported from hustoj are supported.</p>
    <hr>
    <?php if (extension_loaded('xml')): ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'target' => '_blank']]) ?>

    <?= $form->field($model, 'problemFile')->fileInput()
        ->hint("The submitted file is in zip or xml format, file size limit: {$maxFileSize}, the limit is the system limit, if you need to modify the size limit, please modify the post_max_size and upload_max_filesize options of the php.ini file. ")?>


    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end() ?>
    <?php else: ?>
        <p>The server has not enabled the php-xml extension, please install php-xml before using this function. </p>
    <?php endif; ?>
</div>
